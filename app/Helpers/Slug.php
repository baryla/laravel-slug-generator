<?php

namespace App\Helpers;

class Slug
{
    /**
     *
     * Generate a slug from a title and compare it against a model to see if it exists
     *
     * @param class $model
     * @param string $title
     * @return string $slug | $newSlug
     * @throws \Exception
     *
    */
    public function generate($model, $title)
    {
        // Generate the slug from a title
        $slug = str_slug($title);
        // Get all slugs from a particular model that are alike
        $all = $this->find($model, $slug);
        // Check whether $slug exists in the returned array
        if(!$all->contains('slug', $slug)) {
            return $slug;
        }

        // Set the tries to the number of returned slugs.
        // Adding 1 fixes the problem of runnig out of numbers to try against
        $tries = $all->count() + 1;
        for($i = 1; $i <= $tries; $i++) {
            // Append a hyphen and the number to the generated slug using str_slug function
            $newSlug = $slug . '-' . $i;
            // Return the $newSlug if it isn't in our array of slugs ($all) from the DB
            if(!$all->contains('slug', $newSlug)) {
                return $newSlug;
            }
        }

        // If for some reason we can't generate the slug, throw an exception. Very unlikely to happen
        throw new \Exception("Couldn't generate slug", 1);
    }

    /**
     *
     * Find all slugs from a particular model that are similar to $slug
     *
     * @param class $model
     * @param string $slug
     * @return string
     *
    */
    protected function find($model, $slug)
    {
        return $model::select('slug')->where('slug', 'LIKE', '%'.$slug.'%')->get();
    }

}
