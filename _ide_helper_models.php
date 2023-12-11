<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Legacy{
/**
 * App\Legacy\Image
 *
 * @deprecated 
 * @property string $directory
 * @property string $file_name
 * @property string $image_url
 * @property string $raw_url
 * @property int $id
 * @property int|null $width
 * @property int|null $height
 * @property int|null $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Legacy\ImageAssociations> $associations
 * @property-read int|null $associations_count
 * @method static \Illuminate\Database\Eloquent\Builder|Image newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Image query()
 */
	class Image extends \Eloquent {}
}

namespace App\Legacy{
/**
 * App\Legacy\ImageAssociations
 *
 * @deprecated 
 * @property Image         $image
 * @property ImageCategory $category
 * @property int $id
 * @property int $image_id
 * @property int $imageable_id
 * @property string $imageable_type
 * @property int $image_category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $imageable
 * @method static \Illuminate\Database\Eloquent\Builder|ImageAssociations category(int $category)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageAssociations newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageAssociations newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageAssociations query()
 */
	class ImageAssociations extends \Eloquent {}
}

namespace App\Legacy{
/**
 * App\Legacy\ImageCategory
 *
 * @deprecated 
 * @property string $category
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ImageCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageCategory query()
 */
	class ImageCategory extends \Eloquent {}
}

namespace App\Models\Blogs{
/**
 * App\Models\Blogs\Blog
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $body
 * @property int $draft
 * @property int $live
 * @property string $meta_tags
 * @property string $meta_description
 * @property string $publish_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comments\Comment> $allComments
 * @property-read int|null $all_comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Collections\CollectionItem> $associatedCollections
 * @property-read int|null $associated_collections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comments\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read string $absolute_link
 * @property-read string|null $first_legacy_image
 * @property-read string $link
 * @property-read string|null $main_legacy_image
 * @property-read string|null $main_legacy_image_raw
 * @property-read string|null $social_legacy_image
 * @property-read string|null $square_legacy_image
 * @property-read string|null $square_legacy_image_raw
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Legacy\ImageAssociations> $images
 * @property-read int|null $images_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Blogs\BlogTag> $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog query()
 */
	class Blog extends \Eloquent implements \App\Support\Collections\Collectable, \App\Contracts\Comments\HasComments, \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models\Blogs{
/**
 * App\Models\Blogs\BlogTag
 *
 * @property int $id
 * @property string $tag
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Blogs\Blog> $blogs
 * @property-read int|null $blogs_count
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogTag query()
 */
	class BlogTag extends \Eloquent {}
}

namespace App\Models\Collections{
/**
 * App\Models\Collections\Collection
 *
 * @property string $description
 * @property string $meta_tags
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $long_description
 * @property string $body
 * @property int $live
 * @property int $draft
 * @property string $publish_at
 * @property bool $display_on_homepage
 * @property \Illuminate\Support\Carbon|null $remove_from_homepage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $absolute_link
 * @property-read string|null $first_legacy_image
 * @property-read string $link
 * @property-read string|null $main_legacy_image
 * @property-read string|null $main_legacy_image_raw
 * @property-read string|null $social_legacy_image
 * @property-read string|null $square_legacy_image
 * @property-read string|null $square_legacy_image_raw
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Legacy\ImageAssociations> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Collections\CollectionItem> $items
 * @property-read int|null $items_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|Collection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Collection query()
 */
	class Collection extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models\Collections{
/**
 * App\Models\Collections\CollectionItem
 *
 * @property int $id
 * @property int $collection_id
 * @property string $item_type
 * @property int $item_id
 * @property string $description
 * @property int $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Collections\Collection $collection
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $item
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionItem ordered(string $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|CollectionItem query()
 */
	class CollectionItem extends \Eloquent implements \Spatie\EloquentSortable\Sortable {}
}

namespace App\Models\Comments{
/**
 * App\Models\Comments\Comment
 *
 * @property int $id
 * @property int $commentable_id
 * @property string $commentable_type
 * @property string $name
 * @property string $email
 * @property string $comment
 * @property bool $approved
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $commentable
 * @property-read string $what
 * @property-read \App\Models\Comments\CommentReply|null $reply
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Comment query()
 */
	class Comment extends \Eloquent {}
}

namespace App\Models\Comments{
/**
 * App\Models\Comments\CommentReply
 *
 * @property int $id
 * @property int $comment_id
 * @property string $comment_reply
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Comments\Comment $comment
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReply newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommentReply query()
 */
	class CommentReply extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\Eatery
 *
 * @property string | null $average_rating
 * @property string | null $average_expense
 * @property bool | null $has_been_rated
 * @property int | null $rating
 * @property int | null $rating_count
 * @property string $full_name
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property int $town_id
 * @property int $county_id
 * @property int $country_id
 * @property string|null $info
 * @property string $address
 * @property string|null $phone
 * @property string|null $website
 * @property string|null $gf_menu_link
 * @property float $lat
 * @property float $lng
 * @property int|null $type_id
 * @property int|null $venue_type_id
 * @property int|null $cuisine_id
 * @property bool $live
 * @property int $closed_down
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EatingOut\EateryReview|null $adminReview
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\EateryReviewImage> $approvedReviewImages
 * @property-read int|null $approved_review_images_count
 * @property-read \App\Models\EatingOut\NationwideBranch|null $branch
 * @property-read \App\Models\EatingOut\EateryCountry $country
 * @property-read \App\Models\EatingOut\EateryCounty $county
 * @property-read \App\Models\EatingOut\EateryCuisine|null $cuisine
 * @property-read Eatery|null $eatery
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\EateryFeature> $features
 * @property-read int|null $features_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\NationwideBranch> $nationwideBranches
 * @property-read int|null $nationwide_branches_count
 * @property-read \App\Models\EatingOut\EateryOpeningTimes|null $openingTimes
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\EateryReport> $reports
 * @property-read int|null $reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\EateryAttractionRestaurant> $restaurants
 * @property-read int|null $restaurants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\EateryReviewImage> $reviewImages
 * @property-read int|null $review_images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\EateryReview> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\EaterySuggestedEdit> $suggestedEdits
 * @property-read int|null $suggested_edits_count
 * @property-read \App\Models\EatingOut\EateryTown $town
 * @property-read \App\Models\EatingOut\EateryType|null $type
 * @property-read \App\Models\EatingOut\EateryVenueType|null $venueType
 * @method static \Illuminate\Database\Eloquent\Builder|Eatery hasCategories(array $categories)
 * @method static \Illuminate\Database\Eloquent\Builder|Eatery hasFeatures(array $features)
 * @method static \Illuminate\Database\Eloquent\Builder|Eatery hasVenueTypes(array $venueTypes)
 * @method static \Illuminate\Database\Eloquent\Builder|Eatery newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Eatery newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Eatery query()
 */
	class Eatery extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EateryAttractionRestaurant
 *
 * @property int $id
 * @property int $wheretoeat_id
 * @property string $restaurant_name
 * @property string $info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EatingOut\Eatery $eatery
 * @method static \Illuminate\Database\Eloquent\Builder|EateryAttractionRestaurant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryAttractionRestaurant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryAttractionRestaurant query()
 */
	class EateryAttractionRestaurant extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EateryCountry
 *
 * @property string $image
 * @property int $id
 * @property string $country
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\EateryCounty> $counties
 * @property-read int|null $counties_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\Eatery> $eateries
 * @property-read int|null $eateries_count
 * @method static \Illuminate\Database\Eloquent\Builder|EateryCountry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryCountry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryCountry query()
 */
	class EateryCountry extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EateryCounty
 *
 * @property int $id
 * @property string $county
 * @property string $slug
 * @property string|null $latlng
 * @property string $legacy
 * @property int $country_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\EateryTown> $activeTowns
 * @property-read int|null $active_towns_count
 * @property-read \App\Models\EatingOut\EateryCountry $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\Eatery> $eateries
 * @property-read int|null $eateries_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\EateryReview> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\EateryTown> $towns
 * @property-read int|null $towns_count
 * @method static \Illuminate\Database\Eloquent\Builder|EateryCounty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryCounty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryCounty query()
 */
	class EateryCounty extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EateryCuisine
 *
 * @property int $id
 * @property string $cuisine
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\Eatery> $eateries
 * @property-read int|null $eateries_count
 * @method static \Illuminate\Database\Eloquent\Builder|EateryCuisine newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryCuisine newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryCuisine query()
 */
	class EateryCuisine extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EateryFeature
 *
 * @property int $id
 * @property string $feature
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\Eatery> $eateries
 * @property-read int|null $eateries_count
 * @method static \Illuminate\Database\Eloquent\Builder|EateryFeature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryFeature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryFeature query()
 */
	class EateryFeature extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EateryOpeningTimes
 *
 * @property bool $is_open_now
 * @property array $opening_times_array
 * @property int $id
 * @property int $wheretoeat_id
 * @property string|null $monday_start
 * @property string|null $monday_end
 * @property string|null $tuesday_start
 * @property string|null $tuesday_end
 * @property string|null $wednesday_start
 * @property string|null $wednesday_end
 * @property string|null $thursday_start
 * @property string|null $thursday_end
 * @property string|null $friday_start
 * @property string|null $friday_end
 * @property string|null $saturday_start
 * @property string|null $saturday_end
 * @property string|null $sunday_start
 * @property string|null $sunday_end
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EatingOut\Eatery $eatery
 * @method static \Illuminate\Database\Eloquent\Builder|EateryOpeningTimes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryOpeningTimes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryOpeningTimes query()
 */
	class EateryOpeningTimes extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EateryPlaceRequest
 *
 * @method static \Illuminate\Database\Eloquent\Builder|EateryPlaceRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryPlaceRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryPlaceRequest query()
 */
	class EateryPlaceRequest extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EateryRecommendation
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $place_name
 * @property string $place_location
 * @property string|null $place_web_address
 * @property int|null $place_venue_type_id
 * @property string $place_details
 * @property bool $completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EatingOut\EateryVenueType|null $venueType
 * @method static \Illuminate\Database\Eloquent\Builder|EateryRecommendation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryRecommendation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryRecommendation query()
 */
	class EateryRecommendation extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EateryReport
 *
 * @property int $id
 * @property int $wheretoeat_id
 * @property string $details
 * @property bool $completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EatingOut\Eatery $eatery
 * @method static \Illuminate\Database\Eloquent\Builder|EateryReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryReport query()
 */
	class EateryReport extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EateryReview
 *
 * @property Carbon $created_at
 * @property string $human_date
 * @property string $rating
 * @property array | null $price
 * @property int $id
 * @property int $wheretoeat_id
 * @property string $ip
 * @property string|null $name
 * @property string|null $email
 * @property int|null $how_expensive
 * @property string|null $food_rating
 * @property string|null $service_rating
 * @property string|null $branch_name
 * @property string|null $review
 * @property bool $admin_review
 * @property string $method
 * @property bool $approved
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EatingOut\Eatery $eatery
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\EateryReviewImage> $images
 * @property-read int|null $images_count
 * @method static \Illuminate\Database\Eloquent\Builder|EateryReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryReview query()
 */
	class EateryReview extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EateryReviewImage
 *
 * @property string $id
 * @property int $wheretoeat_review_id
 * @property int $wheretoeat_id
 * @property string $thumb
 * @property string $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EatingOut\Eatery $eatery
 * @property-read \App\Models\EatingOut\EateryReview|null $review
 * @method static \Illuminate\Database\Eloquent\Builder|EateryReviewImage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryReviewImage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryReviewImage query()
 */
	class EateryReviewImage extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EaterySearch
 *
 * @property int $id
 * @property int $search_term_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EatingOut\EaterySearchTerm $term
 * @method static \Illuminate\Database\Eloquent\Builder|EaterySearch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EaterySearch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EaterySearch query()
 */
	class EaterySearch extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EaterySearchTerm
 *
 * @property int $id
 * @property string $key
 * @property string $term
 * @property int $range
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\EaterySearch> $searches
 * @property-read int|null $searches_count
 * @method static \Illuminate\Database\Eloquent\Builder|EaterySearchTerm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EaterySearchTerm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EaterySearchTerm query()
 */
	class EaterySearchTerm extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EaterySuggestedEdit
 *
 * @property int $id
 * @property int $wheretoeat_id
 * @property string $field
 * @property string $value
 * @property string $ip
 * @property bool $rejected
 * @property bool $accepted
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EatingOut\Eatery $eatery
 * @method static \Illuminate\Database\Eloquent\Builder|EaterySuggestedEdit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EaterySuggestedEdit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EaterySuggestedEdit query()
 */
	class EaterySuggestedEdit extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EateryTown
 *
 * @property int $id
 * @property string $town
 * @property string $slug
 * @property string|null $latlng
 * @property string $legacy
 * @property int $county_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EatingOut\EateryCounty $county
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\Eatery> $eateries
 * @property-read int|null $eateries_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\NationwideBranch> $liveBranches
 * @property-read int|null $live_branches_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\Eatery> $liveEateries
 * @property-read int|null $live_eateries_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @method static \Illuminate\Database\Eloquent\Builder|EateryTown newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryTown newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryTown query()
 */
	class EateryTown extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EateryType
 *
 * @property int $id
 * @property string $type
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\Eatery> $eateries
 * @property-read int|null $eateries_count
 * @method static \Illuminate\Database\Eloquent\Builder|EateryType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryType query()
 */
	class EateryType extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\EateryVenueType
 *
 * @property int $id
 * @property string $venue_type
 * @property string $slug
 * @property int $type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EatingOut\Eatery> $eateries
 * @property-read int|null $eateries_count
 * @method static \Illuminate\Database\Eloquent\Builder|EateryVenueType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryVenueType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EateryVenueType query()
 */
	class EateryVenueType extends \Eloquent {}
}

namespace App\Models\EatingOut{
/**
 * App\Models\EatingOut\NationwideBranch
 *
 * @property int $id
 * @property int $wheretoeat_id
 * @property string|null $name
 * @property string $slug
 * @property int $country_id
 * @property int $county_id
 * @property int $town_id
 * @property string $address
 * @property float $lat
 * @property float $lng
 * @property bool $live
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EatingOut\EateryCountry $country
 * @property-read \App\Models\EatingOut\EateryCounty $county
 * @property-read \App\Models\EatingOut\Eatery $eatery
 * @property-read \App\Models\EatingOut\EateryTown $town
 * @method static \Illuminate\Database\Eloquent\Builder|NationwideBranch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NationwideBranch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NationwideBranch query()
 */
	class NationwideBranch extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Media
 *
 * @property int $id
 * @property string $model_type
 * @property int $model_id
 * @property string|null $uuid
 * @property string $collection_name
 * @property string $name
 * @property string $file_name
 * @property string|null $mime_type
 * @property string $disk
 * @property string|null $conversions_disk
 * @property int $size
 * @property array $manipulations
 * @property array $custom_properties
 * @property array $generated_conversions
 * @property array $responsive_images
 * @property int|null $order_column
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $model
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> all($columns = ['*'])
 * @method static \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, static> get($columns = ['*'])
 * @method static \Illuminate\Database\Eloquent\Builder|Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Media ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|Media query()
 */
	class Media extends \Eloquent {}
}

namespace App\Models\Recipes{
/**
 * App\Models\Recipes\Recipe
 *
 * @property string $servings
 * @property string $portion_size
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $legacy_slug
 * @property string $meta_tags
 * @property string $meta_description
 * @property string $description
 * @property string $ingredients
 * @property string $method
 * @property string $author
 * @property string $category
 * @property string $serving_size
 * @property string $per
 * @property string $search_tags
 * @property string|null $df_to_not_df
 * @property string $prep_time
 * @property string $cook_time
 * @property int $draft
 * @property int $live
 * @property string $publish_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comments\Comment> $allComments
 * @property-read int|null $all_comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recipes\RecipeAllergen> $allergens
 * @property-read int|null $allergens_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Collections\CollectionItem> $associatedCollections
 * @property-read int|null $associated_collections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comments\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recipes\RecipeFeature> $features
 * @property-read int|null $features_count
 * @property-read string $absolute_link
 * @property-read string|null $first_legacy_image
 * @property-read string $link
 * @property-read string|null $main_legacy_image
 * @property-read string|null $main_legacy_image_raw
 * @property-read string|null $social_legacy_image
 * @property-read string|null $square_legacy_image
 * @property-read string|null $square_legacy_image_raw
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Legacy\ImageAssociations> $images
 * @property-read int|null $images_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recipes\RecipeMeal> $meals
 * @property-read int|null $meals_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \App\Models\Recipes\RecipeNutrition|null $nutrition
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe hasFeatures(array $features)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe hasFreeFrom(array $freeFrom)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe hasMeals(array $meals)
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Recipe query()
 */
	class Recipe extends \Eloquent implements \App\Support\Collections\Collectable, \App\Contracts\Comments\HasComments, \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models\Recipes{
/**
 * App\Models\Recipes\RecipeAllergen
 *
 * @implements FilterableRecipeRelation<self>
 * @property int $id
 * @property string $allergen
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recipes\Recipe> $recipes
 * @property-read int|null $recipes_count
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeAllergen hasRecipesWithFeatures(array $features)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeAllergen hasRecipesWithFreeFrom(array $freeFrom)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeAllergen hasRecipesWithMeals(array $meals)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeAllergen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeAllergen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeAllergen query()
 */
	class RecipeAllergen extends \Eloquent implements \App\Contracts\Recipes\FilterableRecipeRelation {}
}

namespace App\Models\Recipes{
/**
 * App\Models\Recipes\RecipeFeature
 *
 * @implements FilterableRecipeRelation<self>
 * @property int $id
 * @property string $feature
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recipes\Recipe> $recipes
 * @property-read int|null $recipes_count
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeFeature hasRecipesWithFeatures(array $features)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeFeature hasRecipesWithFreeFrom(array $freeFrom)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeFeature hasRecipesWithMeals(array $meals)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeFeature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeFeature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeFeature query()
 */
	class RecipeFeature extends \Eloquent implements \App\Contracts\Recipes\FilterableRecipeRelation {}
}

namespace App\Models\Recipes{
/**
 * App\Models\Recipes\RecipeMeal
 *
 * @implements FilterableRecipeRelation<self>
 * @property int $id
 * @property string $meal
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Recipes\Recipe> $recipes
 * @property-read int|null $recipes_count
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeMeal hasRecipesWithFeatures(array $features)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeMeal hasRecipesWithFreeFrom(array $freeFrom)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeMeal hasRecipesWithMeals(array $meals)
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeMeal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeMeal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeMeal query()
 */
	class RecipeMeal extends \Eloquent implements \App\Contracts\Recipes\FilterableRecipeRelation {}
}

namespace App\Models\Recipes{
/**
 * App\Models\Recipes\RecipeNutrition
 *
 * @property int $id
 * @property int $recipe_id
 * @property int $calories
 * @property int $carbs
 * @property int $fat
 * @property int $protein
 * @property int $fibre
 * @property int $sugar
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Recipes\Recipe $recipe
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeNutrition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeNutrition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|RecipeNutrition query()
 */
	class RecipeNutrition extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TemporaryFileUpload
 *
 * @property string $id
 * @property string $filename
 * @property string $path
 * @property string $source
 * @property int $filesize
 * @property string $mime
 * @property \Illuminate\Support\Carbon $delete_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TemporaryFileUpload newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TemporaryFileUpload newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TemporaryFileUpload query()
 */
	class TemporaryFileUpload extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $phone
 * @property string|null $password
 * @property string|null $api_token
 * @property int $user_level_id
 * @property string|null $remember_token
 * @property string|null $last_logged_in_at
 * @property string|null $last_visited_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $welcome_valid_until
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 */
	class User extends \Eloquent {}
}

