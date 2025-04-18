<?php

declare(strict_types=1);
function safeDecodeAndShorten($html, $limit = 75)
{
    $decoded = htmlspecialchars_decode($html);
    $plain = strip_tags($decoded);
    if (strlen($plain) <= $limit)
        return $decoded;
    return mb_substr($plain, 0, $limit) . '...';
}

function controlInput($input)
{
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    return $input;
}

function insertBlog(string $title, string $description, string $imageUrl, string $slug, float $imdb_rating, string $release_date, int $running_time, bool $isActive)
{
    require 'settings.php';

    // Escape strings
    $title = mysqli_real_escape_string($connection, $title);
    $description = mysqli_real_escape_string($connection, $description);
    $imageUrl = mysqli_real_escape_string($connection, $imageUrl);
    $slug = mysqli_real_escape_string($connection, $slug);
    $release_date = mysqli_real_escape_string($connection, $release_date);

    $isActive = $isActive ? 1 : 0;

    $query = "INSERT INTO `blog` (`title`, `description`, `imageUrl`, `slug`, `imdb_rating`, `release_date`, `running_time`, `isActive`)
              VALUES ('$title', '$description', '$imageUrl', '$slug', $imdb_rating, '$release_date', $running_time, $isActive)";

    $result = mysqli_query($connection, $query);

    if (!$result) {
        die("Query Failed: " . mysqli_error($connection));
    }

    mysqli_close($connection);
    return $result;
}

function selectBlog()
{
    require 'settings.php';

    $query = "Select title, description, imageUrl, slug, imdb_rating, isActive from Blog order by title desc";
    $result = mysqli_query($connection, $query);
    mysqli_close($connection);

    return $result;
}

function selectBlogByTitle(string $title)
{
    require 'settings.php';

    $query = "Select title, description, imageUrl, imdb_rating, release_date, running_time, isActive from Blog Where slug='$title'";
    $result = mysqli_query($connection, $query);
    mysqli_close($connection);

    return $result;
}

function selectCategories()
{
    require 'settings.php';

    $query = "Select * from Categories";
    $result = mysqli_query($connection, $query);
    mysqli_close($connection);

    return $result;
}

function updateCategory(int $id, string $category_name, int $isActive)
{
    require 'settings.php';

    $query = "UPDATE `categories` SET `category_name`='$category_name',`isActive`=$isActive WHERE id=$id";
    $result = mysqli_query($connection, $query);
    mysqli_close($connection);
}

function deleteCategory($id)
{
    require 'settings.php';

    $query = "DELETE FROM `categories` WHERE id=$id";
    $result = mysqli_query($connection, $query);
    mysqli_close($connection);
}

function addCategory(string $category_name, int $isActive)
{
    require 'settings.php';

    $query = "INSERT INTO `categories`(`category_name`, `isActive`) VALUES ('$category_name',$isActive)";
    $result = mysqli_query($connection, $query);
    mysqli_close($connection);

}