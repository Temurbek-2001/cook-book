<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Category extends Model
{
      use HasFactory;

      protected $fillable = [
            'name',
            'description',
      ];

      public function recipes(): HasMany
      {
            return $this->hasMany(Recipe::class);
      }
      
      /**
       * Get the count of recipes in this category.
       */
      public function getRecipesCountAttribute()
      {
            return $this->recipes()->count();
      }
}