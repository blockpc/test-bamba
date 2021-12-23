<?php

if (! function_exists('current_user')) {
    function current_user() {
        return Auth::user();
    }
}

if (! function_exists('image_profile')) {
    function image_profile($user = null) : string
    {
        $user = $user ?? current_user();
        if ( $image = $user->profile->image ) {
            return $image->url;
        } else {
            $name = str_replace(" ", "+", $user->profile->fullName);
            return "https://ui-avatars.com/api/?name={$name}";
        }
    }
}
