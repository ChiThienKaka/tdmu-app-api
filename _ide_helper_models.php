<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $comment_id
 * @property int $post_id
 * @property int $user_id
 * @property string $content
 * @property int|null $parent_comment_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Post $post
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereParentCommentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Comment whereUserId($value)
 */
	class Comment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $faculty_id
 * @property string $faculty_name
 * @property string|null $faculty_code
 * @property string|null $description
 * @property string|null $cover_image
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Major> $majors
 * @property-read int|null $majors_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereFacultyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereFacultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereFacultyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Faculty whereUpdatedAt($value)
 */
	class Faculty extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $group_id
 * @property string $group_name
 * @property string $group_type
 * @property int|null $faculty_id
 * @property int|null $major_id
 * @property string|null $description
 * @property string|null $avatar_url
 * @property string|null $cover_image
 * @property bool $is_auto_join
 * @property string $privacy
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\Faculty|null $faculty
 * @property-read \App\Models\Major|null $major
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\GroupMessage> $messages
 * @property-read int|null $messages_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereFacultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereGroupName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereGroupType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereIsAutoJoin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereMajorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group wherePrivacy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Group whereUpdatedAt($value)
 */
	class Group extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $group_id
 * @property int $user_id
 * @property string $member_role
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Group $group
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMember newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMember newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMember query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMember whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMember whereMemberRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMember whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMember whereUserId($value)
 */
	class GroupMember extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $message_id
 * @property int $group_id
 * @property int $user_id
 * @property string|null $message_content
 * @property string $message_type
 * @property string|null $media_url
 * @property int|null $reply_to_message_id
 * @property bool $is_pinned
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Group $group
 * @property-read GroupMessage|null $parentMessage
 * @property-read \Illuminate\Database\Eloquent\Collection<int, GroupMessage> $replies
 * @property-read int|null $replies_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMessage whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMessage whereIsPinned($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMessage whereMediaUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMessage whereMessageContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMessage whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMessage whereMessageType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMessage whereReplyToMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMessage whereUserId($value)
 */
	class GroupMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMessageMedia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMessageMedia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GroupMessageMedia query()
 */
	class GroupMessageMedia extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $major_id
 * @property int $faculty_id
 * @property string $major_name
 * @property string|null $major_code
 * @property string|null $description
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \App\Models\Faculty $faculty
 * @property-read \App\Models\UserMajor|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Major newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Major newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Major query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Major whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Major whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Major whereFacultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Major whereMajorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Major whereMajorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Major whereMajorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Major whereUpdatedAt($value)
 */
	class Major extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $post_id
 * @property int $user_id
 * @property int|null $faculty_id
 * @property int|null $major_id
 * @property string $content
 * @property string $post_type
 * @property string $visibility
 * @property string $status
 * @property string|null $rejection_reason
 * @property int $view_count
 * @property string|null $moderated_at
 * @property int|null $moderated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comment
 * @property-read int|null $comment_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostMedia> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PostReaction> $postreactions
 * @property-read int|null $postreactions_count
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereFacultyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereMajorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereModeratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereModeratedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post wherePostType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereRejectionReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereViewCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Post whereVisibility($value)
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $media_id
 * @property int $post_id
 * @property string $media_type
 * @property string $media_url
 * @property string $disk
 * @property int $media_order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $url
 * @property-read \App\Models\Post $post
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostMedia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostMedia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostMedia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostMedia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostMedia whereDisk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostMedia whereMediaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostMedia whereMediaOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostMedia whereMediaType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostMedia whereMediaUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostMedia wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostMedia whereUpdatedAt($value)
 */
	class PostMedia extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $reaction_id
 * @property int $post_id
 * @property int $user_id
 * @property string $reaction_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Post $post
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostReaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostReaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostReaction query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostReaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostReaction wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostReaction whereReactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostReaction whereReactionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostReaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PostReaction whereUserId($value)
 */
	class PostReaction extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $role_id
 * @property string $role_name
 * @property string|null $description
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereRoleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $user_id
 * @property string|null $google_id
 * @property string|null $email
 * @property string|null $password
 * @property string|null $full_name
 * @property string|null $avatar_url
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $date_of_birth
 * @property string|null $gender
 * @property int $role_id
 * @property string|null $student_code
 * @property bool $is_verified
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Group> $groups
 * @property-read int|null $groups_count
 * @property-read \App\Models\UserMajor|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Major> $majors
 * @property-read int|null $majors_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \App\Models\Role $role
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereAvatarUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereGoogleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStudentCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUserId($value)
 */
	class User extends \Eloquent implements \PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject {}
}

namespace App\Models{
/**
 * @property int $user_id
 * @property int $major_id
 * @property string|null $class_name
 * @property string|null $academic_year
 * @property string|null $created_at
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMajor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMajor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMajor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMajor whereAcademicYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMajor whereClassName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMajor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMajor whereMajorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMajor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserMajor whereUserId($value)
 */
	class UserMajor extends \Eloquent {}
}

