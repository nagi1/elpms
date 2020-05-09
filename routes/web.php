<?php

// Auth
Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm')->middleware('guest');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login')->middleware('guest');
Route::post('logout')->name('logout')->uses('Auth\LoginController@logout');

// Choose account
Route::get('/accounts')->name('chooseAccount')->uses('ChooseAccountController')->middleware('auth');

// index
Route::get('/{account}')->name('index')->uses('IndexController')->middleware(['auth']);

// create new project
Route::post('{account}/projects')->name('projects.store')->uses('ProjectsController@store');

// show project
Route::get('{account}/projects/{project}')->name('projects.show')->uses('ProjectsController@show');

// rename project
Route::post('{account}/projects/{project}/rename')->name('projects.rename')->uses('RenameProjectController');

// pin project
Route::post('{account}/projects/{project}/pin')->name('projects.pin')->uses('PinProjectController');

// Default sort
Route::put('{account}/projects/{project}/messagesSortBy')->name('projects.messagesSortBy')->uses('MessagesSortByController');

//Archived Messages
Route::get('{account}/projects/{project}/message-boards/archive')->name('messageBoard.archive')->uses('MessageBoardArchiveController');


// message boards
Route::get('{account}/projects/{project}/message-boards/create')->name('messageBoards.create')->uses('MessageBoardsController@create')->middleware(['auth']);

//index
Route::get('{account}/projects/{project}/message-boards')->name('messageBoards.index')->uses('MessageBoardsController@index')->middleware(['auth']);

//drafts
Route::get('{account}/projects/{project}/message-boards/drafts')->name('messageBoards.draft.index')->uses('MessageBoardsDraftController@index')->middleware(['auth']);

//delete drafts
Route::delete('{account}/projects/{project}/message-boards/drafts/{messageBoard}')->name('messageBoards.draft.delete')->uses('MessageBoardsDraftController@delete')->middleware(['auth']);

//drafts
Route::get('{account}/projects/{project}/message-boards/drafts/{messageBoard}')->name('messageBoards.draft.show')->uses('MessageBoardsDraftController@show')->middleware(['auth']);

//publish draft
Route::put('{account}/projects/{project}/message-boards/drafts/{messageBoard}/publish')->name('messageBoards.draft.publish')->uses('PublishMessageBoardController')->middleware(['auth']);

// new message board
Route::post('{account}/projects/{project}/message-boards/create')->name('messageBoards.store')->uses('MessageBoardsController@store');

// show message board
Route::get('{account}/projects/{project}/message-boards/{messageBoard}')->name('messageBoards.show')->uses('ShowMessageBoardMessage');

// edit message board
Route::get('{account}/projects/{project}/message-boards/{messageBoard}/edit')->name('messageBoards.edit')->uses('EditMessageBoard@edit');

// update message board
Route::put('{account}/projects/{project}/message-boards/{messageBoard}/edit')->name('messageBoards.update')->uses('EditMessageBoard@update');


// store category
Route::post('categories')->name('categories.store')->uses('CategoriesController@store');

// edit category
Route::put('categories/{category}')->name('categories.update')->uses('CategoriesController@update');

// delete category
Route::delete('categories/{category}')->name('categories.destroy')->uses('CategoriesController@destroy');

// Comments
Route::post('{account}/projects/{project}/comments/')->name('comments.store')->uses('CommentsController@store');

// Comments update
Route::put('{account}/projects/{project}/comments/{comment}')->name('comments.update')->uses('CommentsController@update');

// Comments delete
Route::post('{account}/projects/{project}/comments/{comment}')->name('comments.delete')->uses('CommentsController@delete');

// Boosts
Route::post('{account}/projects/{project}/boosts/')->name('boosts.store')->uses('BoostsController@store');

// Boosts delete
Route::delete('{account}/projects/{project}/boosts/{boost}')->name('boosts.delete')->uses('BoostsController@delete');


// Move
Route::get('{account}/projects/{project}/move/{model}/{id}')->name('move.show')->uses('MoveController@show');
Route::post('{account}/projects/{project}/move/{model}/{id}')->name('move.store')->uses('MoveController@store');



// Archive
Route::post('{account}/projects/{project}/archive')->name('archive.store')->uses('ArchiveController@store');

//Subscription
Route::put('{account}/projects/{project}/subscription/currentUser')->name('subscription.currentUser')->uses('UpdateCurrentUserSubscriptionController');

Route::get('{account}/projects/{project}/subscriptions/{model}/{modelId}')->name('subscription.show')->uses('SubscriptionController@show');

// // Users
// Route::get('users')->name('users')->uses('UsersController@index')->middleware('remember', 'auth');
// Route::get('users/create')->name('users.create')->uses('UsersController@create')->middleware('auth');
// Route::post('users')->name('users.store')->uses('UsersController@store')->middleware('auth');
// Route::get('users/{user}/edit')->name('users.edit')->uses('UsersController@edit')->middleware('auth');
// Route::put('users/{user}')->name('users.update')->uses('UsersController@update')->middleware('auth');
// Route::delete('users/{user}')->name('users.destroy')->uses('UsersController@destroy')->middleware('auth');
// Route::put('users/{user}/restore')->name('users.restore')->uses('UsersController@restore')->middleware('auth');

// // Images
// Route::get('/img/{path}', 'ImagesController@show')->where('path', '.*');

// // Organizations
// Route::get('organizations')->name('organizations')->uses('OrganizationsController@index')->middleware('remember', 'auth');
// Route::get('organizations/create')->name('organizations.create')->uses('OrganizationsController@create')->middleware('auth');
// Route::post('organizations')->name('organizations.store')->uses('OrganizationsController@store')->middleware('auth');
// Route::get('organizations/{organization}/edit')->name('organizations.edit')->uses('OrganizationsController@edit')->middleware('auth');
// Route::put('organizations/{organization}')->name('organizations.update')->uses('OrganizationsController@update')->middleware('auth');
// Route::delete('organizations/{organization}')->name('organizations.destroy')->uses('OrganizationsController@destroy')->middleware('auth');
// Route::put('organizations/{organization}/restore')->name('organizations.restore')->uses('OrganizationsController@restore')->middleware('auth');

// // Contacts
// Route::get('contacts')->name('contacts')->uses('ContactsController@index')->middleware('remember', 'auth');
// Route::get('contacts/create')->name('contacts.create')->uses('ContactsController@create')->middleware('auth');
// Route::post('contacts')->name('contacts.store')->uses('ContactsController@store')->middleware('auth');
// Route::get('contacts/{contact}/edit')->name('contacts.edit')->uses('ContactsController@edit')->middleware('auth');
// Route::put('contacts/{contact}')->name('contacts.update')->uses('ContactsController@update')->middleware('auth');
// Route::delete('contacts/{contact}')->name('contacts.destroy')->uses('ContactsController@destroy')->middleware('auth');
// Route::put('contacts/{contact}/restore')->name('contacts.restore')->uses('ContactsController@restore')->middleware('auth');

// // Reports
// Route::get('reports')->name('reports')->uses('ReportsController')->middleware('auth');

// // 500 error
// Route::get('500', function () {
//     // Force debug mode for this endpoint in the demo environment
//     if (App::environment('demo')) {
//         Config::set('app.debug', true);
//     }

//     echo $fail;
// });
