<?php

if ( ! App::environment('live') ) {
    /* Temp login */
    Auth::loginUsingId(2);
    // Auth::logout();
}

Route::get('/', 'PageController@index');

Route::post('/login', 'Auth\LoginController@login');
Route::get('/logout', 'Auth\LoginController@logout');

/* Socialite Login */
Route::get('auth/{provider}/callback/', 'Auth\LoginController@handleProviderCallback');
// Route::get('auth/{provider}', 'Auth\LoginController@handleProviderCallback');
Route::get('auth/{site}/{provider}', 'Auth\LoginController@redirectToProvider');

Auth::routes();

/**
 * Cover the Bedford site until live.
 */
Route::get('bedford', function() {
    return redirect('/');
});
Route::get('bedford/{any}', function() {
    return redirect('/');
});

Route::group(['prefix' => '{site}'], function () {

    Route::get('/', 'LocationController@index'); // Homepage of this location

    Route::get('blog', 'BlogController@index'); // Blog landing page

    Route::get('blog/posts', 'PostController@index'); // Posts landing page
    Route::get('blog/posts/search', 'PostSearchController@index');
    Route::get('blog/posts/search/category', 'PostSearchController@category');
    Route::get('blog/posts/{post}', 'PostController@show'); // Posts specific page

    Route::get('blog/rebecca-reviews', 'RebeccaReviewsController@index'); // Rebecca Reviews landing page
    Route::get('blog/rebecca-reviews/search', 'RebeccaReviewSearchController@index');
    Route::get('blog/rebecca-reviews/search/category', 'RebeccaReviewSearchController@category');
    Route::get('blog/rebecca-reviews/{rebeccareview}', 'RebeccaReviewsController@show'); // Rebecca Reviews specific page

    Route::get('holiday-ideas', 'HolidayIdeas\HolidayIdeasController@index'); // Holiday Ideas landing page
    Route::get('holiday-ideas/search', 'HolidayIdeasSearchController@index');
    Route::get('holiday-ideas/search/category', 'HolidayIdeasSearchController@category');
    Route::get('holiday-ideas/{holidayidea}', 'HolidayIdeas\HolidayIdeasController@show'); // Holiday Ideas specific page

    Route::get('users/events', 'User\UserEventController@index');
    Route::get('users/places', 'User\UserPlaceController@index');
    Route::get('users/services', 'User\UserDirectoryController@index');
    Route::get('users/4-plus-activites', 'User\UserAfterSchoolController@index');
    Route::get('users/baby-toddler', 'User\UserBabyToddlerController@index');
    Route::get('users/reviews', 'User\UserReviewsController@index');
    Route::patch('users/reviews/directory/{review}', 'Directory\DirectoryReviewController@update');
    Route::get('users/profile', 'User\UserProfileController@index');
    Route::patch('users/profile', 'User\UserProfileController@update');

    Route::post('/reviews/directory/{directory}', 'Directory\DirectoryReviewController@store');
    Route::post('/reviews/places-to-go/{place}', 'Places\PlaceReviewController@store');
    Route::post('/reviews/4-plus-activites/{afterschoolclub}', 'AfterSchool\AfterSchoolClubReviewController@store');
    Route::post('/reviews/baby-toddler-groups/{babytoddlergroup}', 'BabyToddler\BabyToddlerGroupReviewController@store');

    Route::post('comments/holiday-ideas/{holidayideas}', 'HolidayIdeas\HolidayIdeaCommentController@store');
    Route::get('comments/holiday-ideas/{holidayideas}', 'HolidayIdeas\HolidayIdeaCommentController@show');

    Route::post('comments/posts/{post}', 'Posts\PostCommentController@store');
    Route::get('comments/posts/{post}', 'Posts\PostCommentController@show');

    Route::post('comments/rebecca-reviews/{rebeccareview}', 'RebeccaReview\RebeccaReviewCommentController@store');
    Route::get('comments/rebecca-reviews/{rebeccareview}', 'RebeccaReview\RebeccaReviewCommentController@show');

    /*
    |--------------------------------------------------------------------------
    | Baby and toddler groups
    |--------------------------------------------------------------------------
    |
    */
    Route::group(['namespace' => 'BabyToddler'], function() {
        Route::get('baby-toddler-groups/search', 'BabyToddlerSearchController@search');
        Route::post('baby-toddler-groups/search', 'BabyToddlerSearchController@search');
        Route::get('baby-toddler-groups/search/query', 'BabyToddlerSearchController@query');
        Route::get('baby-toddler-groups/tags', 'BabyToddlerGroupTagsController@all');
        Route::get('baby-toddler-groups', 'BabyToddlerGroupsController@index'); // Baby & toddler group page of this location
        Route::get('baby-toddler-groups/{babytoddlergroup}', 'BabyToddlerGroupsController@show'); // show specific Baby & toddler group page
    });

    /*
    |--------------------------------------------------------------------------
    | After school clubs
    |--------------------------------------------------------------------------
    |
    */
    Route::group(['namespace' => 'AfterSchool'], function() {
        Route::get('4-plus-activites/search', 'AfterSchoolSearchController@search');
        Route::post('4-plus-activites/search', 'AfterSchoolSearchController@search');
        Route::get('4-plus-activites/search/query', 'AfterSchoolSearchController@query');
        Route::get('4-plus-activites/tags', 'AfterSchoolTagsController@all');
        Route::get('4-plus-activites', 'AfterSchoolClubsController@index'); // After school clubs page of this location
        Route::get('4-plus-activites/{afterschoolclub}', 'AfterSchoolClubsController@show'); // show specific After school club page
    });

    /*
    |--------------------------------------------------------------------------
    | Places to go
    |--------------------------------------------------------------------------
    |
    */
    Route::group(['namespace' => 'Places'], function() {
        Route::get('places-to-go/search', 'PlaceSearchController@search');
        Route::post('places-to-go/search', 'PlaceSearchController@search');
        Route::get('places-to-go/search/query', 'PlaceSearchController@query');
        Route::get('places-to-go/tags', 'PlaceTagsController@all');
        Route::get('places-to-go', 'PlaceController@index'); // Places page of this location
        Route::get('places-to-go/{place}', 'PlaceController@show'); // show specific place page
    });

    /*
    |--------------------------------------------------------------------------
    | Events
    |--------------------------------------------------------------------------
    |
    */
    Route::group(['namespace' => 'Events'], function() {
        Route::get('events/search', 'EventSearchController@search');
        Route::post('events/search', 'EventSearchController@search');
        Route::get('events/search/query', 'EventSearchController@query');
        Route::get('events/tags', 'EventTagsController@all');
        Route::get('events', 'EventController@index'); // Events page of this location
        Route::get('events/{event}', 'EventController@show'); // show specific event page
    });

    /*
    |--------------------------------------------------------------------------
    | Directory
    |--------------------------------------------------------------------------
    |
    */
    Route::group(['namespace' => 'Directory'], function() {
        Route::get('directory/search', 'DirectorySearchController@search');
        Route::post('directory/search', 'DirectorySearchController@search');
        Route::get('directory/search/query', 'DirectorySearchController@query');
        Route::get('directory/tags', 'DirectoryTagsController@all');
        Route::get('directory', 'DirectoryController@index'); // Directory page of this location
        Route::get('directory/{directory}', 'DirectoryController@show'); // show specific directory page
    });

    /*
    |--------------------------------------------------------------------------
    | AskMum
    |--------------------------------------------------------------------------
    |
    */
    Route::group(['namespace' => 'AskMum'], function() {
        Route::get('askmum', 'AskMumController@index');
        Route::get('askmum/{question}', 'AskMumController@show');
    });

    Route::get('planner/{date}/search/', 'PlannerController@search');
    Route::get('planner/{date}', 'PlannerController@index');
    Route::get('planner/', 'PlannerController@index');

    /*
    |--------------------------------------------------------------------------
    | Search Overlay
    |--------------------------------------------------------------------------
    |
    */
    Route::get('search/tags', 'Search\SearchController@searchTag');
    Route::get('search/events/{term}', 'Search\SearchController@searchEvents');
    Route::get('search/after-school/{term}', 'Search\SearchController@searchAfterSchool');
    Route::get('search/baby-toddler/{term}', 'Search\SearchController@searchBabyToddler');

    Route::post('tracking/searchterm', 'Tracking\TrackingController@searchTerm');


    /* Favouriting Models */
    Route::post('/favourite/event/{event}', 'Events\EventFavouriteController@store');
    Route::delete('/favourite/event/{event}', 'Events\EventFavouriteController@destroy');

    Route::post('/favourite/places/{place}', 'Places\PlaceFavouriteController@store');
    Route::delete('/favourite/places/{place}', 'Places\PlaceFavouriteController@destroy');

    Route::post('/favourite/baby-toddler-groups/{babytoddlergroup}', 'BabyToddler\BabyToddlerFavouriteController@store');
    Route::delete('/favourite/baby-toddler-groups/{babytoddlergroup}', 'BabyToddler\BabyToddlerFavouriteController@destroy');

    Route::post('/favourite/4-plus-activites/{afterschoolclub}', 'AfterSchool\AfterSchoolFavouriteController@store');
    Route::delete('/favourite/4-plus-activites/{afterschoolclub}', 'AfterSchool\AfterSchoolFavouriteController@destroy');

    Route::post('/favourite/directory/{directory}', 'Directory\DirectoryFavouriteController@store');
    Route::delete('/favourite/directory/{directory}', 'Directory\DirectoryFavouriteController@destroy');


    Route::get('{page}', 'PageController@show');

});
