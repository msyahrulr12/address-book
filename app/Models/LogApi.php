<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogApi extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_name',
        'url',
        'headers',
        'queries',
        'request_datetime',
        'request_body',
        'response_datetime',
        'response_body',
    ];

    # User
    public const API_USER_LIST = 'USER_LIST';
    public const API_USER_SHOW = 'USER_SHOW';
    public const API_USER_CREATE = 'USER_CREATE';
    public const API_USER_UPDATE = 'USER_UPDATE';
    public const API_USER_DELETE = 'USER_DELETE';

    # Address Book
    public const API_ADDRESS_BOOK_LIST = 'ADDRESS_BOOK_LIST';
    public const API_ADDRESS_BOOK_SHOW = 'ADDRESS_BOOK_SHOW';
    public const API_ADDRESS_BOOK_CREATE = 'ADDRESS_BOOK_CREATE';
    public const API_ADDRESS_BOOK_UPDATE = 'ADDRESS_BOOK_UPDATE';
    public const API_ADDRESS_BOOK_DELETE = 'ADDRESS_BOOK_DELETE';
    public const API_ADDRESS_BOOK_IMPORT = 'ADDRESS_BOOK_IMPORT';
    public const API_ADDRESS_BOOK_EXPORT = 'ADDRESS_BOOK_EXPORT';
}
