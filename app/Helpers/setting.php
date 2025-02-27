<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

function setting()
{
	return $setting = Setting::first();
}

function themeStyle()
{
	$theme = Setting::find(1);
	if($theme){
		if($theme->theme_style == 1){
			$theme_style = 'light-theme';
		}else{
			$theme_style = 'dark-theme';
		}
	}else{
		$theme_style = 'light-theme';
	}
	
	 return $theme_style;
}


