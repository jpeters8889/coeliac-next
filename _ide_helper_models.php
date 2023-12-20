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
 * @property-read string|null $first_legacy_image
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
 * @property-read string|null $first_legacy_image
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
 * @property int $id
 * @property string $name
 * @property string $addOrRemove
 * @property string $details
 * @property bool $completed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
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
 * @property-read string|null $first_legacy_image
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

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopCategory
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property string $meta_keywords
 * @property string $meta_description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string|null $first_legacy_image
 * @property-read string|null $main_legacy_image
 * @property-read string|null $main_legacy_image_raw
 * @property-read string|null $social_legacy_image
 * @property-read string|null $square_legacy_image
 * @property-read string|null $square_legacy_image_raw
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Legacy\ImageAssociations> $images
 * @property-read int|null $images_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopProduct> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|ShopCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopCategory query()
 */
	class ShopCategory extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopDiscountCode
 *
 * @property int $id
 * @property int $type_id
 * @property string $name
 * @property string $code
 * @property string $start_at
 * @property string $end_at
 * @property int $max_claims
 * @property int|null $min_spend
 * @property int $deduction
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopOrder> $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\Shop\ShopDiscountCodeType $type
 * @method static \Illuminate\Database\Eloquent\Builder|ShopDiscountCode newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopDiscountCode newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopDiscountCode query()
 */
	class ShopDiscountCode extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopDiscountCodeType
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopDiscountCode> $codes
 * @property-read int|null $codes_count
 * @method static \Illuminate\Database\Eloquent\Builder|ShopDiscountCodeType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopDiscountCodeType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopDiscountCodeType query()
 */
	class ShopDiscountCodeType extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopDiscountCodesUsed
 *
 * @property int $id
 * @property int $discount_id
 * @property int $order_id
 * @property int $discount_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Shop\ShopDiscountCode $code
 * @property-read \App\Models\Shop\ShopOrder $order
 * @method static \Illuminate\Database\Eloquent\Builder|ShopDiscountCodesUsed newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopDiscountCodesUsed newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopDiscountCodesUsed query()
 */
	class ShopDiscountCodesUsed extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopFeedback
 *
 * @property int $id
 * @property string $name
 * @property string $feedback
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Shop\ShopProduct $product
 * @method static \Illuminate\Database\Eloquent\Builder|ShopFeedback newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopFeedback newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopFeedback query()
 */
	class ShopFeedback extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopOrder
 *
 * @property int $id
 * @property int $state_id
 * @property int $postage_country_id
 * @property string $token
 * @property string|null $order_key
 * @property int|null $user_id
 * @property int|null $user_address_id
 * @property string|null $shipped_at
 * @property int $newsletter_signup
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\UserAddress|null $address
 * @property-read \App\Models\Shop\ShopDiscountCode|null $discountCode
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopOrderItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\Shop\ShopPayment|null $payment
 * @property-read \App\Models\Shop\ShopPostageCountry $postageCountry
 * @property-read \App\Models\Shop\ShopOrderReviewInvitation|null $reviewInvitation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopOrderReviewItem> $reviewedItems
 * @property-read int|null $reviewed_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopOrderReview> $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopSource> $sources
 * @property-read int|null $sources_count
 * @property-read \App\Models\Shop\ShopOrderState $state
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrder query()
 */
	class ShopOrder extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopOrderItem
 *
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property int $product_variant_id
 * @property int $quantity
 * @property string $product_title
 * @property int $product_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Shop\ShopOrder $order
 * @property-read \App\Models\Shop\ShopProduct $product
 * @property-read \App\Models\Shop\ShopProductVariant $variant
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderItem query()
 */
	class ShopOrderItem extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopOrderReview
 *
 * @property int $id
 * @property int|null $order_id
 * @property string|null $invitation_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Shop\ShopOrderReviewInvitation|null $invitation
 * @property-read \App\Models\Shop\ShopOrder|null $order
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopOrderReviewItem> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderReview query()
 */
	class ShopOrderReview extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopOrderReviewInvitation
 *
 * @property string $id
 * @property int $sent
 * @property int $order_id
 * @property string|null $sent_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Shop\ShopOrder $order
 * @property-read \App\Models\Shop\ShopOrderReview|null $review
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderReviewInvitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderReviewInvitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderReviewInvitation query()
 */
	class ShopOrderReviewInvitation extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopOrderReviewItem
 *
 * @property int $id
 * @property int $review_id
 * @property int|null $order_id
 * @property int $product_id
 * @property string $rating
 * @property string|null $review
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Shop\ShopOrder|null $order
 * @property-read \App\Models\Shop\ShopOrderReview|null $parent
 * @property-read \App\Models\Shop\ShopProduct $product
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderReviewItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderReviewItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderReviewItem query()
 */
	class ShopOrderReviewItem extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopOrderState
 *
 * @property int $id
 * @property string $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopOrder> $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderState newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderState newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopOrderState query()
 */
	class ShopOrderState extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopPayment
 *
 * @property int $id
 * @property int $order_id
 * @property int $subtotal
 * @property int $discount
 * @property int $postage
 * @property int $total
 * @property int $payment_type_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Shop\ShopOrder $order
 * @property-read \App\Models\Shop\ShopPaymentResponse|null $response
 * @property-read \App\Models\Shop\ShopPaymentType $type
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPayment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPayment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPayment query()
 */
	class ShopPayment extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopPaymentResponse
 *
 * @property int $id
 * @property int $payment_id
 * @property array $response
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Shop\ShopPayment $payment
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPaymentResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPaymentResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPaymentResponse query()
 */
	class ShopPaymentResponse extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopPaymentType
 *
 * @property int $id
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopPayment> $payment
 * @property-read int|null $payment_count
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPaymentType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPaymentType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPaymentType query()
 */
	class ShopPaymentType extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopPostageCountry
 *
 * @property int $id
 * @property int $postage_area_id
 * @property string $country
 * @property string $iso_code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Shop\ShopPostageCountryArea $area
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopOrder> $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPostageCountry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPostageCountry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPostageCountry query()
 */
	class ShopPostageCountry extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopPostageCountryArea
 *
 * @property int $id
 * @property string $area
 * @property string $delivery_timescale
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopPostageCountry> $countries
 * @property-read int|null $countries_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopPostagePrice> $postagePrices
 * @property-read int|null $postage_prices_count
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPostageCountryArea newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPostageCountryArea newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPostageCountryArea query()
 */
	class ShopPostageCountryArea extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopPostagePrice
 *
 * @property int $id
 * @property int $postage_country_area_id
 * @property int $shipping_method_id
 * @property int $max_weight
 * @property int $price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Shop\ShopPostageCountryArea $area
 * @property-read \App\Models\Shop\ShopShippingMethod $shippingMethod
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPostagePrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPostagePrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopPostagePrice query()
 */
	class ShopPostagePrice extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopProduct
 *
 * @property int $currentPrice
 * @property null | int $oldPrice
 * @property int $id
 * @property string $title
 * @property int $pinned
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $slug
 * @property string $description
 * @property string $long_description
 * @property int $shipping_method_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopCategory> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopFeedback> $feedback
 * @property-read int|null $feedback_count
 * @property-read string|null $first_legacy_image
 * @property-read string|null $main_legacy_image
 * @property-read string|null $main_legacy_image_raw
 * @property-read string|null $social_legacy_image
 * @property-read string|null $square_legacy_image
 * @property-read string|null $square_legacy_image_raw
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Legacy\ImageAssociations> $images
 * @property-read int|null $images_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \App\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopProductPrice> $prices
 * @property-read int|null $prices_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopOrderReviewItem> $reviews
 * @property-read int|null $reviews_count
 * @property-read \App\Models\Shop\ShopShippingMethod $shippingMethod
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\TravelCardSearchTerm> $travelCardSearchTerms
 * @property-read int|null $travel_card_search_terms_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopProductVariant> $variants
 * @property-read int|null $variants_count
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProduct query()
 */
	class ShopProduct extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopProductPrice
 *
 * @property int $id
 * @property int $product_id
 * @property int $price
 * @property int $sale_price
 * @property \Illuminate\Support\Carbon $start_at
 * @property \Illuminate\Support\Carbon|null $end_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Shop\ShopProduct $product
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProductPrice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProductPrice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProductPrice query()
 */
	class ShopProductPrice extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopProductVariant
 *
 * @property int $id
 * @property int $product_id
 * @property int $live
 * @property string $title
 * @property int $weight
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Shop\ShopProduct $product
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProductVariant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProductVariant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopProductVariant query()
 */
	class ShopProductVariant extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopShippingMethod
 *
 * @property int $id
 * @property string $shipping_method
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopPostagePrice> $prices
 * @property-read int|null $prices_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopProduct> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|ShopShippingMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopShippingMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopShippingMethod query()
 */
	class ShopShippingMethod extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\ShopSource
 *
 * @property int $id
 * @property string $source
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopOrder> $orders
 * @property-read int|null $orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSource newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSource newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShopSource query()
 */
	class ShopSource extends \Eloquent {}
}

namespace App\Models\Shop{
/**
 * App\Models\Shop\TravelCardSearchTerm
 *
 * @property int $id
 * @property string $term
 * @property string $type
 * @property int $hits
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopProduct> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|TravelCardSearchTerm newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TravelCardSearchTerm newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TravelCardSearchTerm query()
 */
	class TravelCardSearchTerm extends \Eloquent {}
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
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserAddress> $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserAddress
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $name
 * @property string $line_1
 * @property string|null $line_2
 * @property string|null $line_3
 * @property string $town
 * @property string $postcode
 * @property string $country
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Shop\ShopOrder> $orders
 * @property-read int|null $orders_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAddress withoutTrashed()
 */
	class UserAddress extends \Eloquent {}
}

