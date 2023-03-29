<?php

function checkAccountUser(SitePageData $sitePageData){
    if ($sitePageData->userID < 1){
        HTTP::redirect('/account/auth');
    }elseif(Arr::path($sitePageData->user->getOptionsArray(), 'is_load_passport', FALSE)){
        if ($sitePageData->url != '/account/profile/edit') {
            HTTP::redirect('/account/profile/edit');
        }
    }elseif(! Arr::path($sitePageData->user->getOptionsArray(), 'is_filled', FALSE)){
        if ($sitePageData->url != '/account/profile/edit') {
            HTTP::redirect('/account/profile/edit');
        }
    }
}