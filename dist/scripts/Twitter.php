<?php
/**
 * Connect to Twitter API and retrieve Tweets
 *
 * @author Koury Lape
 * @link http://github.com/ckylape
 * @version 1.0
 */
class Twitter
{
    const version = '1.0';

    protected static $oauth;
    protected static $oauth_access_token;
    protected static $oauth_access_token_secret;
    protected static $consumer_key;
    protected static $consumer_secret;

    /**
     * Method for creating a base string from an array and base URI.
     *
     * @param string $baseURI the URI of the request to Twitter
     * @param string $method the method of the request (GET|POST|PUT|DELETE)
     * @param array $params the OAuth associative array
     * @return string the encoded base string
     */
    private static function buildBaseString($baseURI, $method, $params) {
        $r = array();
        ksort($params);
        foreach($params as $key=>$value){
            $r[] = "$key=" . rawurlencode($value);
        }
        return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
    } //end buildBaseString()

    /**
     * Method for creating the composite key.
     *
     * @return string the composite key.
     **/
    private static function getCompositeKey() {
        return rawurlencode(self::$consumer_secret) . '&' . rawurlencode(self::$oauth_access_token_secret);
    } //end getCompositeKey()

    /**
     * Method for building the OAuth header.
     *
     * @return string the authorization header.
     **/
    private static function buildAuthorizationHeader() {
        $r = 'Authorization: OAuth ';
        $values = array();
        foreach(self::$oauth as $key => $value)
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        $r .= implode(', ', $values);
        return $r;
    } //end buildAuthorizationHeader()

    /**
     * Method for generating the OAuth array.
     *
     * @return void
     **/
    private static function generateOauth () {
        self::$oauth_access_token        = get_option('wprdc_theme_setting_twitter_at');
        self::$oauth_access_token_secret = get_option('wprdc_theme_setting_twitter_ats');
        self::$consumer_key              = get_option('wprdc_theme_setting_twitter_ck');
        self::$consumer_secret           = get_option('wprdc_theme_setting_twitter_cs');
        self::$oauth = array(
            'oauth_consumer_key' => self::$consumer_key,
            'oauth_nonce' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token' => self::$oauth_access_token,
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0'
        );
    } //end generateOauth()

    /**
     * Method for generating the OAuth Signature.
     *
     * @param $baseURI string the URI of the request to Twitter
     * @param $method string the method of the request (GET|POST|PUT|DELETE)
     * @param $params array associative array for request parameters
     **/
    private static function setSignature($baseURI, $method, $params) {
        $baseString = self::buildBaseString($baseURI, $method, array_merge(self::$oauth,$params));
        $compositeKey = self::getCompositeKey();
        self::$oauth['oauth_signature'] = base64_encode(hash_hmac('sha1', $baseString, $compositeKey, true));
    } //end setSignature()

    /**
     * Method for sending a request to Twitter.
     *
     * @param string $baseURI the request URI
     * @param array|null $params the parameters of the request
     * @return string the response from Twitter
     **/
    public static function getRequest($baseURI, $params = array()) {
        self::generateOauth();
        self::setSignature($baseURI, 'GET',  $params);
        $header = array(self::buildAuthorizationHeader(), 'Expect:');
        $options = array(
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_HEADER => false,
            CURLOPT_URL => $baseURI . '?' . http_build_query($params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        );
        $ch = curl_init();
        curl_setopt_array( $ch, $options );
        $response = curl_exec( $ch );
        curl_close($ch);
        return json_decode($response);
    } // end getRequest()

    /**
     * Changes Twitter API Object to Twitter Styled Tweet with Links/Formatting
     *
     * @param $tweet object Twitter Object returned from Twitter API v1.1
     * @param $links bool enables formatting http links
     * @param $media bool enables formatting of media links
     * @param $users bool enables formatting twitter users
     * @param $hashtags bool enables formatting of hashtags
     * @return string Formatted Tweet
     */
    public static function prettifyTweets($tweet, $links = true, $media = true, $users = true, $hashtags = true)
    {
        // Main Array
        $replacements = array();

        // Check if Tweet is a Re-Tweet
        if (isset($tweet->retweeted_status)) {
            $entities = $tweet->retweeted_status->entities;
            $text = $tweet->retweeted_status->text;
            $rt_user = $tweet->retweeted_status->user->screen_name;
            $rt = "RT <a href=\"https://twitter.com/{$rt_user}\" target=\"_blank\">@{$rt_user}</a>: ";
        } else {
            $entities = $tweet->entities;
            $text = $tweet->text;
            $rt = '';
        }

        // URLS
        if ($links && property_exists($entities, 'urls')) {
            foreach ($entities->urls as $e) {
                list ($start, $end) = $e->indices;
                $replacements[$start] = array($start, $end,
                    "<a href=\"{$e->expanded_url}\">{$e->display_url}</a>");
            }
        }

        // Media
        if ($media && property_exists($entities, 'media')) {
            foreach ($entities->media as $e) {
                list ($start, $end) = $e->indices;
                $replacements[$start] = array($start, $end,
                    "<a href=\"{$e->expanded_url}\" target=\"_blank\">{$e->url}</a>");
            }
        }

        // User Mentions
        if ($users && property_exists($entities, 'user_mentions')) {
            foreach ($entities->user_mentions as $e) {
                list ($start, $end) = $e->indices;
                $replacements[$start] = array($start, $end,
                    "<a href=\"https://twitter.com/{$e->screen_name}\" target=\"_blank\">@{$e->screen_name}</a>");
            }
        }

        // Hashtags
        if ($hashtags && property_exists($entities, 'hashtags')) {
            foreach ($entities->hashtags as $e) {
                list ($start, $end) = $e->indices;
                $replacements[$start] = array($start, $end,
                    "<a href=\"https://twitter.com/hashtag/{$e->text}\" target=\"_blank\">#{$e->text}</a>");
            }
        }

        // Sort Replacement Array in Reverse Order
        krsort($replacements);

        // Cycle through and Apply Changes
        foreach ($replacements as $replace_data) {
            list ($start, $end, $replace_text) = $replace_data;
            $splitA = mb_substr($text, 0, $start, "UTF-8");
            $splitB = mb_substr($text, ($start + ($end - $start)), mb_strlen($text), "UTF-8");
            $text = $splitA . $replace_text . $splitB;
        }

        return $rt . $text;
    }// end twitterApiToHtml()


    /**
     * Get Tweets using Twitter's API and store them in APC cache
     *
     * @return array|static[] Array of Tweets
     */
    public static function getTweets()
    {
        if( !wincache_ucache_exists('tweets') )
        {
            $array = array();
            $user = get_option('wprdc_theme_setting_twitter') ? get_option('wprdc_theme_setting_twitter') : 'WPRDC';

            //retrieve new tweets
            $tweets = Twitter::getRequest('https://api.twitter.com/1.1/statuses/user_timeline.json', array(
                'screen_name' => $user,
                'count' => 5
            ));

            if(isset($tweets->errors))
                return $array;

            foreach ($tweets as $tweet)
            {
                $array[] = Twitter::prettifyTweets($tweet);
            }

            wincache_ucache_set('tweets',$array,900);

            return $array;
        }

        return wincache_ucache_get('tweets');

    }// end getTweets()

}