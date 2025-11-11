<?php

namespace App\Enums;

enum Social: int
{
    case Facebook = 1;
    case Twitter = 2;
    case Google = 3;
    case YouTube = 4;
    case Instagram = 5;
    case Pinterest = 6;
    case LinkedIn = 7;
    case TikTok = 8;
    case Snapchat = 9;
    case Reddit = 10;
    case Discord = 11;
    case Twitch = 12;
    case GitHub = 13;
    case GitLab = 14;
    case Medium = 15;
    case WhatsApp = 16;
    case Telegram = 17;
    case Signal = 18;
    case Vimeo = 19;
    case Dribbble = 20;
    case Behance = 21;
    case Spotify = 22;
    case Apple = 23;
    case Microsoft = 24;
    case Slack = 25;
    case Zoom = 26;
    case Skype = 27;

    /**
     * Get the display name for the social platform
     */
    public function label(): string
    {
        return match($this) {
            self::Facebook => 'Facebook',
            self::Twitter => 'Twitter / X',
            self::Google => 'Google',
            self::YouTube => 'YouTube',
            self::Instagram => 'Instagram',
            self::Pinterest => 'Pinterest',
            self::LinkedIn => 'LinkedIn',
            self::TikTok => 'TikTok',
            self::Snapchat => 'Snapchat',
            self::Reddit => 'Reddit',
            self::Discord => 'Discord',
            self::Twitch => 'Twitch',
            self::GitHub => 'GitHub',
            self::GitLab => 'GitLab',
            self::Medium => 'Medium',
            self::WhatsApp => 'WhatsApp',
            self::Telegram => 'Telegram',
            self::Signal => 'Signal',
            self::Vimeo => 'Vimeo',
            self::Dribbble => 'Dribbble',
            self::Behance => 'Behance',
            self::Spotify => 'Spotify',
            self::Apple => 'Apple',
            self::Microsoft => 'Microsoft',
            self::Slack => 'Slack',
            self::Zoom => 'Zoom',
            self::Skype => 'Skype',
        };
    }

    /**
     * Get the icon class or identifier for the social platform
     */
    public function icon(): string
    {
        return match($this) {
            self::Facebook => 'fab fa-facebook',
            self::Twitter => 'fab fa-twitter',
            self::Google => 'fab fa-google',
            self::YouTube => 'fab fa-youtube',
            self::Instagram => 'fab fa-instagram',
            self::Pinterest => 'fab fa-pinterest',
            self::LinkedIn => 'fab fa-linkedin',
            self::TikTok => 'fab fa-tiktok',
            self::Snapchat => 'fab fa-snapchat',
            self::Reddit => 'fab fa-reddit',
            self::Discord => 'fab fa-discord',
            self::Twitch => 'fab fa-twitch',
            self::GitHub => 'fab fa-github',
            self::GitLab => 'fab fa-gitlab',
            self::Medium => 'fab fa-medium',
            self::WhatsApp => 'fab fa-whatsapp',
            self::Telegram => 'fab fa-telegram',
            self::Signal => 'fas fa-comment',
            self::Vimeo => 'fab fa-vimeo',
            self::Dribbble => 'fab fa-dribbble',
            self::Behance => 'fab fa-behance',
            self::Spotify => 'fab fa-spotify',
            self::Apple => 'fab fa-apple',
            self::Microsoft => 'fab fa-microsoft',
            self::Slack => 'fab fa-slack',
            self::Zoom => 'fab fa-zoom',
            self::Skype => 'fab fa-skype',
        };
    }

    /**
     * Get the base URL for the social platform profile
     */
    public function baseUrl(): string
    {
        return match($this) {
            self::Facebook => 'https://facebook.com/',
            self::Twitter => 'https://twitter.com/',
            self::Google => 'https://profiles.google.com/',
            self::YouTube => 'https://youtube.com/@',
            self::Instagram => 'https://instagram.com/',
            self::Pinterest => 'https://pinterest.com/',
            self::LinkedIn => 'https://linkedin.com/in/',
            self::TikTok => 'https://tiktok.com/@',
            self::Snapchat => 'https://snapchat.com/add/',
            self::Reddit => 'https://reddit.com/user/',
            self::Discord => 'https://discord.com/users/',
            self::Twitch => 'https://twitch.tv/',
            self::GitHub => 'https://github.com/',
            self::GitLab => 'https://gitlab.com/',
            self::Medium => 'https://medium.com/@',
            self::WhatsApp => 'https://wa.me/',
            self::Telegram => 'https://t.me/',
            self::Signal => 'signal://',
            self::Vimeo => 'https://vimeo.com/',
            self::Dribbble => 'https://dribbble.com/',
            self::Behance => 'https://behance.net/',
            self::Spotify => 'https://open.spotify.com/user/',
            self::Apple => 'https://appleid.apple.com/',
            self::Microsoft => 'https://account.microsoft.com/profile/',
            self::Slack => 'https://slack.com/',
            self::Zoom => 'https://zoom.us/profile/',
            self::Skype => 'https://skype.com/',
        };
    }

    /**
     * Get all social platforms as an array for dropdowns
     */
    public static function toArray(): array
    {
        $array = [];
        foreach (self::cases() as $case) {
            $array[$case->value] = $case->label();
        }
        return $array;
    }

    /**
     * Get social platform by name
     */
    public static function fromName(string $name): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->name === $name) {
                return $case;
            }
        }
        return null;
    }

    /**
     * Check if this is a messaging platform
     */
    public function isMessaging(): bool
    {
        return in_array($this, [
            self::WhatsApp,
            self::Telegram,
            self::Signal,
            self::Discord,
            self::Slack,
        ]);
    }

    /**
     * Check if this is a professional platform
     */
    public function isProfessional(): bool
    {
        return in_array($this, [
            self::LinkedIn,
            self::GitHub,
            self::GitLab,
            self::Behance,
            self::Dribbble,
        ]);
    }

    /**
     * Check if this is a media platform
     */
    public function isMedia(): bool
    {
        return in_array($this, [
            self::YouTube,
            self::Vimeo,
            self::Twitch,
            self::TikTok,
            self::Instagram,
        ]);
    }
}
