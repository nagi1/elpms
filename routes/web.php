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
Route::post('{account}/{project}/rename')->name('projects.rename')->uses('RenameProjectController');

// pin project
Route::post('{account}/{project}/pin')->name('projects.pin')->uses('PinProjectController');


// message boards
Route::get('{account}/{project}/message-boards/new')->name('messageBoards.create')->uses('MessageBoardsController@create');

//index
Route::get('{account}/{project}/message-boards')->name('messageBoards.index')->uses('MessageBoardsController@index');

//store
Route::post('{account}/{project}/message-boards/new')->name('messageBoards.store')->uses('MessageBoardsController@store');


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
