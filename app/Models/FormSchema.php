<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSchema extends Model
{
	use HasFactory;

	protected $fillable = ['schema'];
}
