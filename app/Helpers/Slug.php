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
     * @param class $thisModel = NULL
     * @return string $slug | $newSlug
     * @throws \Exception
     *
    */
    public function generate($model, $title, $thisModel = NULL)
    {
        // Generate the slug from a title
        $slug = str_slug($title);
        // Get all slugs from a particular model that are alike
        $all = $this->find($model, $slug);
        // Check whether $slug exists in the returned array
        if(!$all->contains('slug', $slug)) {
            return $slug;
        }
        // Check whether the $slug exists in the array and if the slug is the same as the one in the current model
        // If this is true, it means that there's no need to generate a new slug
        if($all->contains('slug', $slug) && $thisModel !== NULL && $thisModel->slug === $slug) {
            return $slug;
        }

        // Set the tries to the number of returned slugs.
        // Adding 1 fixes the problem of runnig out of numbers to try against
        $tries = $all->count() + 1;
        for($i = 1; $i <= $tries; $i++) {
            // Append a hyphen and the number to the generated slug using str_slug function
            $newSlug = $slug . '-' . $i;
            // Check whether $thisModel is not NULL
            if($thisModel !== NULL) {
                // If the $newSlug is the same as the current model slug
                if($newSlug === $thisModel->slug) {
                    return $newSlug;
                }
                // If the current model is null and the $newSlug is not in the array
                // Essentially means to generate a completely new slug
            } else if($thisModel === NULL && !$all->contains('slug', $newSlug)) {
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
        return $model::select('id','slug')->where('slug', 'LIKE', '%'.$slug.'%')->get();
    }

}
