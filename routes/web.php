<?php

// Archives

// Archived todo items
Route::get('{account}/projects/{project}/todo-lists/{todoList}/todo-items/archive')->name('todoItems.archive')->uses('TodoItems\TodoItemsArchiveIndexController');

// Archived Message boards
Route::get('{account}/projects/{project}/message-boards/archive')->name('messageBoards.archive')->uses('MessageBoards\MessageBoardsArchiveIndexController');

// Archived todo lists
Route::get('{account}/projects/{project}/todo-lists/archive')->name('todoLists.archive')->uses('TodoLists\TodoListsArchiveIndexController');



// Message Boards

// Create message board
Route::get('{account}/projects/{project}/message-boards/create')->name('messageBoards.create')->uses('MessageBoards\MessageBoardsController@create')->middleware(['auth']);

// Message boards index
Route::get('{account}/projects/{project}/message-boards')->name('messageBoards.index')->uses('MessageBoards\MessageBoardsController@index')->middleware(['auth']);

// Message boards drafts index
Route::get('{account}/projects/{project}/message-boards/drafts')->name('messageBoards.draft.index')->uses('MessageBoards\MessageBoardsDraftController@index')->middleware(['auth']);

// Delete message board draft
Route::delete('{account}/projects/{project}/message-boards/drafts/{messageBoard}')->name('messageBoards.draft.delete')->uses('MessageBoards\MessageBoardsDraftController@delete')->middleware(['auth']);

// Show message board draft
Route::get('{account}/projects/{project}/message-boards/drafts/{messageBoard}')->name('messageBoards.draft.show')->uses('MessageBoards\MessageBoardsDraftController@show')->middleware(['auth']);

// Publish message board draft
Route::put('{account}/projects/{project}/message-boards/drafts/{messageBoard}/publish')->name('messageBoards.draft.publish')->uses('MessageBoards\PublishMessageBoardsController')->middleware(['auth']);

// Store message board
Route::post('{account}/projects/{project}/message-boards/create')->name('messageBoards.store')->uses('MessageBoards\MessageBoardsController@store');

// Show message board
Route::get('{account}/projects/{project}/message-boards/{messageBoard}')->name('messageBoards.show')->uses('MessageBoards\ShowMessageBoardMessageController');

// Edit message board
Route::get('{account}/projects/{project}/message-boards/{messageBoard}/edit')->name('messageBoards.edit')->uses('MessageBoards\EditMessageBoardsController@edit');

// Update message board
Route::put('{account}/projects/{project}/message-boards/{messageBoard}/edit')->name('messageBoards.update')->uses('MessageBoards\EditMessageBoardsController@update');


// Categories

// Store category
Route::post('categories')->name('categories.store')->uses('Categories\CategoriesController@store');

// Edit category
Route::put('categories/{category}')->name('categories.update')->uses('Categories\CategoriesController@update');

// Delete category
Route::delete('categories/{category}')->name('categories.destroy')->uses('Categories\CategoriesController@destroy');




// Hill Chart

// Enable/Disable
Route::put('{account}/projects/{project}/hillChart')->name('hillCharts.enable')->uses('TodoLists\HillChartController@update');

// Post Update
Route::post('{account}/projects/{project}/hillChart')->name('hillCharts.update')->uses('TodoLists\HillChartController@store');

// update index
Route::get('{account}/projects/{project}/hillChart/updates')->name('hillCharts.index')->uses('TodoLists\HillChartController@index');


// Delete update
Route::delete('{account}/projects/{project}/hillChart/updates/{hillChartUpdate}')->name('hillChartsUpdates.delete')->uses('TodoLists\HillChartController@destroy');

// Edit Update
Route::put('{account}/projects/{project}/hillChart/updates/{hillChartUpdate}')->name('hillChartsUpdates.update')->uses('TodoLists\EditHillChartUpdateController');


// show update
Route::get('{account}/projects/{project}/hillChart/updates/{hillChartUpdate}')->name('hillChartsUpdates.show')->uses('TodoLists\ShowHillChartUpdateController');


// Comments

// Stor comment
Route::post('{account}/projects/{project}/comments/')->name('comments.store')->uses('Comments\CommentsController@store');

// Update comments
Route::put('{account}/projects/{project}/comments/{comment}')->name('comments.update')->uses('Comments\CommentsController@update');

// Delete comments
Route::post('{account}/projects/{project}/comments/{comment}')->name('comments.delete')->uses('Comments\CommentsController@delete');


//Boosts

// Store boosts
Route::post('{account}/projects/{project}/boosts/')->name('boosts.store')->uses('Boosts\BoostsController@store');

// Delete Boosts
Route::delete('{account}/projects/{project}/boosts/{boost}')->name('boosts.delete')->uses('Boosts\BoostsController@delete');



// Move

// Show move
Route::get('{account}/projects/{project}/move/{model}/{modelId}')->name('move.show')->uses('Move\MoveController@show');

// store move
Route::post('{account}/projects/{project}/move/{model}/{modelId}')->name('move.store')->uses('Move\MoveController@store');


// Archive
Route::post('{account}/projects/{project}/archive')->name('archive.store')->uses('Archive\ArchiveController@store');


// Trash
Route::post('{account}/projects/{project}/trash')->name('trash.store')->uses('Trash\TrashController@store');

// Trash index
Route::get('{account}/projects/{project}/trash')->name('trash.index')->uses('Trash\TrashIndexController');

// Subscriptions

// Update current user subscription
Route::put('{account}/projects/{project}/subscription/currentUser')->name('subscription.currentUser')->uses('Subscriptions\UpdateCurrentUserSubscriptionController');

// Show subscriptions
Route::get('{account}/projects/{project}/subscriptions/{model}/{modelId}')->name('subscription.show')->uses('Subscriptions\SubscriptionsController@show');

// Update subscriptions
Route::put('{account}/projects/{project}/subscriptions/{model}/{modelId}')->name('subscription.update')->uses('Subscriptions\SubscriptionsController@update');

// Todo lists


// Sort Todo lists
Route::put('{account}/projects/{project}/todo-lists/sort')->name('todoLists.sort')->uses('TodoLists\UpdateTodoListsSortController')->middleware(['auth']);

// Todo lists index
Route::get('{account}/projects/{project}/todo-lists')->name('todoLists.index')->uses('TodoLists\TodoListsController@index')->middleware(['auth']);

// Show Todo lists
Route::get('{account}/projects/{project}/todo-lists/{todoList}')->name('todoLists.show')->uses('TodoLists\ShowTodoListsController')->middleware(['auth']);

// Store Todo lists
Route::post('{account}/projects/{project}/todo-lists')->name('todoLists.store')->uses('TodoLists\TodoListsController@store')->middleware(['auth']);

// Update Todo lists
Route::put('{account}/projects/{project}/todo-lists/{todoList}')->name('todoLists.update')->uses('TodoLists\TodoListsController@update')->middleware(['auth']);



// Todo items

// Sort Todo items
Route::put('{account}/projects/{project}/todo-lists/{todoList}/todo-items/sort')->name('todoItems.sort')->uses('TodoItems\UpdateTodoItemsSortController')->middleware(['auth']);

// Mark todo items
Route::put('{account}/projects/{project}/todo-lists/{todoList}/todo-items/{todoItem}/mark')->name('todoItems.mark')->uses('TodoItems\MarkTodoItemsController')->middleware(['auth']);

// Store todo items
Route::post('{account}/projects/{project}/todo-lists/{todoList}/todo-items')->name('todoItems.store')->uses('TodoItems\TodoItemsController@store')->middleware(['auth']);

// Update todo items
Route::put('{account}/projects/{project}/todo-lists/{todoList}/todo-items/{todoItem}')->name('todoItems.update')->uses('TodoItems\TodoItemsController@update')->middleware(['auth']);

// Show todo items
Route::get('{account}/projects/{project}/todo-lists/{todoList}/todo-items/{todoItem}')->name('todoItems.show')->uses('TodoItems\ShowTodoItemsController')->middleware(['auth']);


// Schedule

// Schedule index
Route::get('{account}/projects/{project}/schedule')->name('schedule.index')->uses('Schedule\ScheduleController@index')->middleware(['auth']);

// Schedule index
Route::post('{account}/projects/{project}/schedule')->name('events.store')->uses('Events\EventsController@store')->middleware(['auth']);


// Projects

// Create project
Route::post('{account}/projects')->name('projects.store')->uses('Projects\ProjectsController@store');

// Show project
Route::get('{account}/projects/{project}')->name('projects.show')->uses('Projects\ProjectsController@show');

// Rename project
Route::post('{account}/projects/{project}/rename')->name('projects.rename')->uses('Projects\RenameProjectController');

// Pin project
Route::post('{account}/projects/{project}/pin')->name('projects.pin')->uses('Projects\PinProjectController');

// Message boards default sort
Route::put('{account}/projects/{project}/messagesSortBy')->name('projects.messagesSortBy')->uses('MessageBoards\MessageBoardsSortByController');

// Auth
Route::get('login')->name('login')->uses('Auth\LoginController@showLoginForm')->middleware('guest');
Route::post('login')->name('login.attempt')->uses('Auth\LoginController@login')->middleware('guest');
Route::post('logout')->name('logout')->uses('Auth\LoginController@logout')->middleware(['auth']);

// Choose account
Route::get('/accounts')->name('chooseAccount')->uses('Accounts\ChooseAccountController')->middleware('auth');

// index
Route::get('/{account}')->name('index')->uses('Home\IndexController')->middleware(['auth']);
