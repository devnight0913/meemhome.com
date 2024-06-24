<?php

namespace App\Models;

use App\Services\Strings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Settings extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'value',
    ];

    public const ADMIN_EMAIL = 1;
    public const ADDRESS = 2;
    public const EMAIL = 3;
    public const PHONE = 4;
    public const ABOUT = 5;
    public const GOOGLE_MAPS_SHARE_LINK = 6;
    public const GOOGLE_MAPS_IFRAME = 7;
    public const FACEBOOK_URL = 8;
    public const INSTAGRAM_URL = 9;
    public const TWITTER_URL = 10;
    public const YOUTUBE_URL = 11;
    public const TIKTOK_URL = 12;
    public const GLOBAL_ALERT = 13;
    public const WHATSAPP = 14;
    public const META_TITLE = 15;
    public const META_DESCRIPTION = 16;
    public const KEYWORDS = 17;
    public const GOOGLE_PLAY_URL = 18;
    public const APP_STORE_URL = 19;
    public const FACEBOOK_MESSENGER = 20;

    public static $settings = [
        self::ADMIN_EMAIL => "ADMIN_EMAIL",
        self::ADDRESS => "ADDRESS",
        self::EMAIL => "EMAIL",
        self::PHONE => "PHONE",
        self::ABOUT => "ABOUT",
        self::GOOGLE_MAPS_SHARE_LINK => "GOOGLE_MAPS_SHARE_LINK",
        self::GOOGLE_MAPS_IFRAME => "GOOGLE_MAPS_IFRAME",
        self::FACEBOOK_URL => "FACEBOOK_URL",
        self::INSTAGRAM_URL => "INSTAGRAM_URL",
        self::TWITTER_URL => "TWITTER_URL",
        self::YOUTUBE_URL => "YOUTUBE_URL",
        self::TIKTOK_URL => "TIKTOK_URL",
        self::GLOBAL_ALERT => "GLOBAL_ALERT",
        self::WHATSAPP => "WHATSAPP",
        self::META_TITLE => "META_TITLE",
        self::META_DESCRIPTION => "META_DESCRIPTION",
        self::KEYWORDS => "KEYWORDS",
        self::GOOGLE_PLAY_URL => "GOOGLE_PLAY_URL",
        self::APP_STORE_URL => "APP_STORE_URL",
        self::FACEBOOK_MESSENGER => "FACEBOOK_MESSENGER",
    ];

    public static $values = [
        self::ADMIN_EMAIL => "admin@email.com",
        self::ADDRESS => "Address",
        self::EMAIL => "info@email",
        self::PHONE => "+961 XXXXXXXXX",
        self::ABOUT => "About us",
        self::GOOGLE_MAPS_SHARE_LINK => "https://goo.gl/maps/UVyvQv3dSjZoCMia9",
        self::GOOGLE_MAPS_IFRAME => '<iframe src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d3307.7094120518886!2d36.199998!3d33.99999700000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zMzPCsDU5JzYwLjAiTiAzNsKwMTEnNjAuMCJF!5e0!3m2!1sen!2sby!4v1668934445639!5m2!1sen!2sby" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        self::FACEBOOK_URL => "https://www.facebook.com/",
        self::INSTAGRAM_URL => "https://www.instagram.com",
        self::TWITTER_URL => null,
        self::YOUTUBE_URL => "https://www.youtube.com/channel/UCNbnvendgPYxpWT7BgZTx8g",
        self::TIKTOK_URL => null,
        self::GLOBAL_ALERT => null,
        self::WHATSAPP => "9613068074",
        self::META_TITLE => "MeemHome",
        self::META_DESCRIPTION => "MeemHome Online Shopping",
        self::KEYWORDS => "MeemHome, Batteries",
        self::GOOGLE_PLAY_URL => null,
        self::APP_STORE_URL => null,
        self::FACEBOOK_MESSENGER => "https://www.facebook.com/messages/t/",
    ];


    /**
     * Admin email Settings.
     * 
     */
    public static function getFacebookMessengerValue()
    {
        return Cache::rememberForever(self::$settings[self::FACEBOOK_MESSENGER], function () {
            return self::getFacebookMessenger()->value;
        });
    }
    public static function getFacebookMessenger()
    {
        return Settings::where('id', self::FACEBOOK_MESSENGER)->first();
    }
    public static function updateFacebookMessenger(?string $value)
    {
        self::getFacebookMessenger()->update(['value' => $value]);
        Cache::forget(self::$settings[self::FACEBOOK_MESSENGER]);
    }


    /**
     * Admin email Settings.
     * 
     */
    public static function getAdminEmailValue()
    {
        return Cache::rememberForever(self::$settings[self::ADMIN_EMAIL], function () {
            return self::getAdminEmail()->value;
        });
    }
    public static function getAdminEmail()
    {
        return Settings::where('id', self::ADMIN_EMAIL)->first();
    }
    public static function updateAdminEmail(?string $value)
    {
        self::getAdminEmail()->update(['value' => $value]);
        Cache::forget(self::$settings[self::ADMIN_EMAIL]);
    }

    /**
     * Google play url Settings.
     * 
     */
    public static function getGooglePlayUrlValue()
    {
        return Cache::rememberForever(self::$settings[self::GOOGLE_PLAY_URL], function () {
            return self::getGooglePlayUrl()->value;
        });
    }
    public static function getGooglePlayUrl()
    {
        return Settings::where('id', self::GOOGLE_PLAY_URL)->first();
    }
    public static function updateGooglePlayUrl(?string $value)
    {
        self::getGooglePlayUrl()->update(['value' => $value]);
        Cache::forget(self::$settings[self::GOOGLE_PLAY_URL]);
    }


    /**
     * Google play url Settings.
     * 
     */
    public static function getAppStoreUrlValue()
    {
        return Cache::rememberForever(self::$settings[self::APP_STORE_URL], function () {
            return self::getAppStoreUrl()->value;
        });
    }
    public static function getAppStoreUrl()
    {
        return Settings::where('id', self::APP_STORE_URL)->first();
    }
    public static function updateAppStoreUrl(?string $value)
    {
        self::getAppStoreUrl()->update(['value' => $value]);
        Cache::forget(self::$settings[self::APP_STORE_URL]);
    }



    /**
     * meta title  Settings.
     * 
     */
    public static function getMetaTitleValue()
    {
        return Cache::rememberForever(self::$settings[self::META_TITLE], function () {
            return self::getMetaTitle()->value;
        });
    }
    public static function getMetaTitle()
    {
        return Settings::where('id', self::META_TITLE)->first();
    }
    public static function updateMetaTitle(?string $value)
    {
        self::getMetaTitle()->update(['value' => $value]);
        Cache::forget(self::$settings[self::META_TITLE]);
    }

    /**
     * meta description  Settings.
     * 
     */
    public static function getMetaDescriptionValue()
    {
        return Cache::rememberForever(self::$settings[self::META_DESCRIPTION], function () {
            return self::getMetaDescription()->value;
        });
    }
    public static function getMetaDescription()
    {
        return Settings::where('id', self::META_DESCRIPTION)->first();
    }
    public static function updateMetaDescription(?string $value)
    {
        self::getMetaDescription()->update(['value' => $value]);
        Cache::forget(self::$settings[self::META_DESCRIPTION]);
    }

    /**
     * meta keywords  Settings.
     * 
     */
    public static function getKeywordsValue()
    {
        return Cache::rememberForever(self::$settings[self::KEYWORDS], function () {
            return self::getKeywords()->value;
        });
    }
    public static function getKeywords()
    {
        return Settings::where('id', self::KEYWORDS)->first();
    }
    public static function updateKeywords(?string $value)
    {
        self::getKeywords()->update(['value' => $value]);
        Cache::forget(self::$settings[self::KEYWORDS]);
    }



    /**
     * Whatsapp  Settings.
     * 
     */
    public static function getWhatsappValue()
    {
        return Cache::rememberForever(self::$settings[self::WHATSAPP], function () {
            return self::getWhatsapp()->value;
        });
    }
    public static function getWhatsapp()
    {
        return Settings::where('id', self::WHATSAPP)->first();
    }
    public static function updateWhatsapp(?string $value)
    {
        self::getWhatsapp()->update(['value' => $value]);
        Cache::forget(self::$settings[self::WHATSAPP]);
    }

    /**
     * TikTok url Settings.
     * 
     */
    public static function getTikTokUrlValue()
    {
        return Cache::rememberForever(self::$settings[self::TIKTOK_URL], function () {
            return self::getTikTokUrl()->value;
        });
    }
    public static function getTikTokUrl()
    {
        return Settings::where('id', self::TIKTOK_URL)->first();
    }
    public static function updateTikTokUrl(?string $value)
    {
        self::getTikTokUrl()->update(['value' => $value]);
        Cache::forget(self::$settings[self::TIKTOK_URL]);
    }

    /**
     * Youtube url Settings.
     * 
     */
    public static function getYouTubeUrlValue()
    {
        return Cache::rememberForever(self::$settings[self::YOUTUBE_URL], function () {
            return self::getYouTubeUrl()->value;
        });
    }
    public static function getYouTubeUrl()
    {
        return Settings::where('id', self::YOUTUBE_URL)->first();
    }
    public static function updateYouTubeUrl(?string $value)
    {
        self::getYouTubeUrl()->update(['value' => $value]);
        Cache::forget(self::$settings[self::YOUTUBE_URL]);
    }

    /**
     * Twitter url Settings.
     * 
     */
    public static function getTwitterUrlValue()
    {
        return Cache::rememberForever(self::$settings[self::TWITTER_URL], function () {
            return self::getTwitterUrl()->value;
        });
    }
    public static function getTwitterUrl()
    {
        return Settings::where('id', self::TWITTER_URL)->first();
    }
    public static function updateTwitterUrl(?string $value)
    {
        self::getTwitterUrl()->update(['value' => $value]);
        Cache::forget(self::$settings[self::TWITTER_URL]);
    }


    /**
     * Instagram url Settings.
     * 
     */
    public static function getInstagramUrlValue()
    {
        return Cache::rememberForever(self::$settings[self::INSTAGRAM_URL], function () {
            return self::getInstagramUrl()->value;
        });
    }
    public static function getInstagramUrl()
    {
        return Settings::where('id', self::INSTAGRAM_URL)->first();
    }
    public static function updateInstagramUrl(?string $value)
    {
        self::getInstagramUrl()->update(['value' => $value]);
        Cache::forget(self::$settings[self::INSTAGRAM_URL]);
    }

    /**
     * Facebook url Settings.
     * 
     */
    public static function getFacebookUrlValue()
    {
        return Cache::rememberForever(self::$settings[self::FACEBOOK_URL], function () {
            return self::getFacebookUrl()->value;
        });
    }
    public static function getFacebookUrl()
    {
        return Settings::where('id', self::FACEBOOK_URL)->first();
    }
    public static function updateFacebookUrl(?string $value)
    {
        self::getFacebookUrl()->update(['value' => $value]);
        Cache::forget(self::$settings[self::FACEBOOK_URL]);
    }


    /**
     * Google Maps IFram Settings.
     * 
     */
    public static function getGoogleMapsIFrameValue()
    {
        return Cache::rememberForever(self::$settings[self::GOOGLE_MAPS_IFRAME], function () {
            return self::getGoogleMapsIFrame()->value;
        });
    }
    public static function getGoogleMapsIFrame()
    {
        return Settings::where('id', self::GOOGLE_MAPS_IFRAME)->first();
    }
    public static function updateGoogleMapsIFrame(?string $value)
    {
        self::getGoogleMapsIFrame()->update(['value' => $value]);
        Cache::forget(self::$settings[self::GOOGLE_MAPS_IFRAME]);
    }



    /**
     * Google Maps Share Link Settings.
     * 
     */
    public static function getGoogleMapsShareLinkValue()
    {
        return Cache::rememberForever(self::$settings[self::GOOGLE_MAPS_SHARE_LINK], function () {
            return self::getGoogleMapsShareLink()->value;
        });
    }
    public static function getGoogleMapsShareLink()
    {
        return Settings::where('id', self::GOOGLE_MAPS_SHARE_LINK)->first();
    }
    public static function updateGoogleMapsShareLink(?string $value)
    {
        self::getGoogleMapsShareLink()->update(['value' => $value]);
        Cache::forget(self::$settings[self::GOOGLE_MAPS_SHARE_LINK]);
    }


    /**
     * About Settings.
     * 
     */
    public static function getAboutValue()
    {
        return Cache::rememberForever(self::$settings[self::ABOUT], function () {
            return self::getAbout()->value;
        });
    }
    public static function getAbout()
    {
        return Settings::where('id', self::ABOUT)->first();
    }
    public static function updateAbout(?string $value)
    {
        self::getAbout()->update(['value' => $value]);
        Cache::forget(self::$settings[self::ABOUT]);
    }

    /**
     * Phone Settings.
     * 
     */
    public static function getPhoneValue()
    {
        return Cache::rememberForever(self::$settings[self::PHONE], function () {
            return self::getPhone()->value;
        });
    }

    public static function getPhone()
    {
        return Settings::where('id', self::PHONE)->first();
    }

    public static function updatePhone(?string $value)
    {
        self::getPhone()->update(['value' => $value]);
        Cache::forget(self::$settings[self::PHONE]);
    }


    /**
     * Email Settings.
     * 
     */
    public static function getEmailValue()
    {
        return Cache::rememberForever(self::$settings[self::EMAIL], function () {
            return self::getEmail()->value;
        });
    }
    public static function getEmail()
    {
        return Settings::where('id', self::EMAIL)->first();
    }

    public static function updateEmail(?string $value)
    {
        self::getEmail()->update(['value' => $value]);
        Cache::forget(self::$settings[self::EMAIL]);
    }


    /**
     * Address Settings.
     * 
     */
    public static function getAddressValue()
    {
        return Cache::rememberForever(self::$settings[self::ADDRESS], function () {
            return Settings::getAddress()->value;
        });
    }
    public static function getAddress()
    {
        return Settings::where('id', self::ADDRESS)->first();
    }
    public static function updateAddress(?string $value)
    {
        self::getAddress()->update(['value' => $value]);
        Cache::forget(self::$settings[self::ADDRESS]);
    }


    /**
     * global_alert Settings.
     * 
     */
    public static function getGlobalAlertValue()
    {
        return Cache::rememberForever(self::$settings[self::GLOBAL_ALERT], function () {
            return Settings::getGlobalAlert()->value;
        });
    }
    public static function getGlobalAlert()
    {
        return Settings::where('id', self::GLOBAL_ALERT)->first();
    }
    public static function updateGlobalAlert(?string $value)
    {
        self::getGlobalAlert()->update(['value' => $value]);
        Cache::forget(self::$settings[self::GLOBAL_ALERT]);
    }




    public static function updateByKey(string $key, ?string $value)
    {
        $id = array_search($key, self::$settings);
        if (!$id) return;
        $setting = Settings::where('id', $id)->first();
        if (!$setting) return;
        $setting->update(['value' => $value]);
        Cache::forget($key);
    }
}
