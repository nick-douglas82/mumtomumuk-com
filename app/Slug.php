<?php

namespace App;

Use App\User;

class Slug
{
    /**
     * Handle slugs a little better when it comes to creating users
     *
     * @return string
     */
    public static function create($name = null)
    {
        // If $name is not null
        if ( ! is_null( $name ) ) {

            // Normalise the name
            $slug = str_slug($name);

            // Get any users that have the same slug as the one created
            $allSlugs = User::where('slug', 'like', $slug . '%')->get();

            // If there aren't any with the same slug then return the created slug
            if ( ! $allSlugs->contains('slug', $slug) ) {
                return $slug;
            }

            // If we found a slug, then loop through (10) times and look in the collection for an item with that number
            // if not found, return the new slug created
            for ( $i = 1; $i <= 10; $i++ ) {
                $newSlug = $slug . '-' . $i;
                if ( ! $allSlugs->contains('slug', $newSlug)) {
                    return $newSlug;
                }
            }
        }
    }
}
