<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\ChatGroup;
use App\Models\ChatGroupMember;
use App\Models\Message;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Batch;

class ChatController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CHAT PAGE
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $user = Auth::user();

        $batches = Batch::query()
            ->with('chatGroup')
            ->orderByDesc('batch_year')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DIRECT CONTACTS
        |--------------------------------------------------------------------------
        */

        $users = $this->getContacts($user);


        /*
        |--------------------------------------------------------------------------
        | GROUPS
        |--------------------------------------------------------------------------
        */

        $groups = ChatGroup::query()
            ->whereHas('members', function ($query) use ($user) {

                $query->where(
                    'user_id',
                    $user->id
                );

            })
            ->with([
                'creator',
                'members.user',
            ])
            ->withCount('members')
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | SELECTED CHAT TYPE
        |--------------------------------------------------------------------------
        */

        $type = $request->input('type', 'direct');

        if (!in_array($type, ['direct', 'group'])) {
            $type = 'direct';
        }


        /*
        |--------------------------------------------------------------------------
        | SELECTED DIRECT USER
        |--------------------------------------------------------------------------
        */

        $receiverId = $request->integer(
            'receiver_id'
        );

        $receiver = null;


        /*
        |--------------------------------------------------------------------------
        | SELECTED GROUP
        |--------------------------------------------------------------------------
        */

        $groupId = $request->integer(
            'group_id'
        );

        $selectedGroup = null;


        /*
        |--------------------------------------------------------------------------
        | MESSAGES
        |--------------------------------------------------------------------------
        */

        $messages = collect();


        /*
        |--------------------------------------------------------------------------
        | DIRECT CHAT
        |--------------------------------------------------------------------------
        */

        if (
            $type === 'direct' &&
            $receiverId
        ) {

            $receiver = User::find(
                $receiverId
            );


            if (
                !$receiver ||
                !$this->canChatWith(
                    $user,
                    $receiver
                )
            ) {

                $receiverId = null;
                $receiver = null;

            } else {

                $messages = Message::query()
                    ->whereNull('chat_group_id')
                    ->where(function ($query) use (
                        $user,
                        $receiverId
                    ) {

                        $query
                            ->where('sender_id', $user->id)
                            ->where('receiver_id', $receiverId);

                    })
                    ->orWhere(function ($query) use (
                        $user,
                        $receiverId
                    ) {

                        $query
                            ->where('sender_id', $receiverId)
                            ->where('receiver_id', $user->id);

                    })
                    ->orderBy(
                        'created_at',
                        'asc'
                    )
                    ->get();


                /*
                |--------------------------------------------------------------------------
                | READ DIRECT MESSAGES
                |--------------------------------------------------------------------------
                */

                Message::query()
                    ->whereNull('chat_group_id')
                    ->where('sender_id', $receiverId)
                    ->where('receiver_id', $user->id)
                    ->where('is_read', false)
                    ->update([
                        'is_read' => true,
                        'read_at' => now(),
                    ]);


                /*
                |--------------------------------------------------------------------------
                | DELIVER DIRECT MESSAGES
                |--------------------------------------------------------------------------
                */

                Message::query()
                    ->whereNull('chat_group_id')
                    ->where('sender_id', $receiverId)
                    ->where('receiver_id', $user->id)
                    ->where('is_delivered', false)
                    ->update([
                        'is_delivered' => true,
                        'delivered_at' => now(),
                    ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | GROUP CHAT
        |--------------------------------------------------------------------------
        */

        if (
            $type === 'group' &&
            $groupId
        ) {

            $selectedGroup = ChatGroup::query()
                ->with([
                    'creator',
                    'members.user',
                ])
                ->withCount('members')
                ->find($groupId);


            /*
            |--------------------------------------------------------------------------
            | SECURITY
            |--------------------------------------------------------------------------
            */

            if (
                !$selectedGroup ||
                !$selectedGroup->members()
                    ->where('user_id', $user->id)
                    ->exists()
            ) {

                $selectedGroup = null;
                $groupId = null;

            } else {

                /*
                |--------------------------------------------------------------------------
                | GROUP MESSAGES
                |--------------------------------------------------------------------------
                */

                $messages = Message::query()
                    ->where(
                        'chat_group_id',
                        $groupId
                    )
                    ->with('sender')
                    ->orderBy(
                        'created_at',
                        'asc'
                    )
                    ->get();


                /*
                |--------------------------------------------------------------------------
                | GROUP READ STATUS
                |--------------------------------------------------------------------------
                */

                Message::query()
                    ->where(
                        'chat_group_id',
                        $groupId
                    )
                    ->where(
                        'sender_id',
                        '!=',
                        $user->id
                    )
                    ->where('is_read', false)
                    ->update([
                        'is_read' => true,
                        'read_at' => now(),
                    ]);


                /*
                |--------------------------------------------------------------------------
                | GROUP DELIVERY STATUS
                |--------------------------------------------------------------------------
                */

                Message::query()
                    ->where(
                        'chat_group_id',
                        $groupId
                    )
                    ->where(
                        'sender_id',
                        '!=',
                        $user->id
                    )
                    ->where('is_delivered', false)
                    ->update([
                        'is_delivered' => true,
                        'delivered_at' => now(),
                    ]);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | DIRECT LAST MESSAGES
        |--------------------------------------------------------------------------
        */

        $lastMessages = [];

        $unreadMessages = [];


        foreach ($users as $contact) {

            $last = Message::query()
                ->whereNull('chat_group_id')
                ->where(function ($query) use (
                    $user,
                    $contact
                ) {

                    $query
                        ->where('sender_id', $user->id)
                        ->where('receiver_id', $contact->id);

                })
                ->orWhere(function ($query) use (
                    $user,
                    $contact
                ) {

                    $query
                        ->where('sender_id', $contact->id)
                        ->where('receiver_id', $user->id);

                })
                ->latest('created_at')
                ->first();


            if ($last) {

                $lastMessages[$contact->id] =
                    $last->message
                    ?: (
                        $last->file
                            ? '📎 Attachment'
                            : 'Message'
                    );

            } else {

                $lastMessages[$contact->id] =
                    null;
            }


            /*
            |--------------------------------------------------------------------------
            | UNREAD DIRECT
            |--------------------------------------------------------------------------
            */

            $unreadMessages[$contact->id] =
                Message::query()
                    ->whereNull('chat_group_id')
                    ->where(
                        'sender_id',
                        $contact->id
                    )
                    ->where(
                        'receiver_id',
                        $user->id
                    )
                    ->where(
                        'is_read',
                        false
                    )
                    ->count();
        }


        /*
        |--------------------------------------------------------------------------
        | GROUP LAST MESSAGES
        |--------------------------------------------------------------------------
        */

        $groupLastMessages = [];

        $groupUnreadMessages = [];


        foreach ($groups as $group) {

            $last = Message::query()
                ->where(
                    'chat_group_id',
                    $group->id
                )
                ->latest('created_at')
                ->first();


            if ($last) {

                $groupLastMessages[$group->id] =
                    $last->message
                    ?: (
                        $last->file
                            ? '📎 Attachment'
                            : 'Message'
                    );

            } else {

                $groupLastMessages[$group->id] =
                    'No messages yet';
            }


            /*
            |--------------------------------------------------------------------------
            | UNREAD GROUP
            |--------------------------------------------------------------------------
            */

            $groupUnreadMessages[$group->id] =
                Message::query()
                    ->where(
                        'chat_group_id',
                        $group->id
                    )
                    ->where(
                        'sender_id',
                        '!=',
                        $user->id
                    )
                    ->where(
                        'is_read',
                        false
                    )
                    ->count();
        }


        /*
        |--------------------------------------------------------------------------
        | RETURN
        |--------------------------------------------------------------------------
        */

        return view(
            'chat.index',
            compact(
                'users',
                'groups',
                'batches',
                'messages',
                'receiverId',
                'receiver',
                'groupId',
                'selectedGroup',
                'type',
                'lastMessages',
                'unreadMessages',
                'groupLastMessages',
                'groupUnreadMessages'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SEND MESSAGE
    |--------------------------------------------------------------------------
    */

    public function send(Request $request)
    {
        $request->validate([

            'message' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'file' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,gif,webp,svg,pdf,doc,docx',
                'max:10240',
            ],

            'receiver_id' => [
                'nullable',
                'integer',
                'exists:users,id',
            ],

            'group_id' => [
                'nullable',
                'integer',
                'exists:chat_groups,id',
            ],

        ]);


        $sender = Auth::user();


        $messageText = trim(
            (string) $request->input(
                'message',
                ''
            )
        );


        /*
        |--------------------------------------------------------------------------
        | REQUIRE MESSAGE OR FILE
        |--------------------------------------------------------------------------
        */

        if (
            $messageText === '' &&
            !$request->hasFile('file')
        ) {

            return back()->with(
                'error',
                'Please enter a message or attach a file.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILE
        |--------------------------------------------------------------------------
        */

        $filePath = null;


        if ($request->hasFile('file')) {

            $filePath =
                $request
                    ->file('file')
                    ->store(
                        'chat_files',
                        'public'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | GROUP MESSAGE
        |--------------------------------------------------------------------------
        */

        if ($request->filled('group_id')) {

            $group = ChatGroup::findOrFail(
                $request->group_id
            );


            /*
            |--------------------------------------------------------------------------
            | MEMBER CHECK
            |--------------------------------------------------------------------------
            */

            $isMember =
                $group
                    ->members()
                    ->where(
                        'user_id',
                        $sender->id
                    )
                    ->exists();


            if (!$isMember) {

                if ($filePath) {
                    Storage::disk('public')
                        ->delete($filePath);
                }

                abort(403);
            }


            /*
            |--------------------------------------------------------------------------
            | CREATE GROUP MESSAGE
            |--------------------------------------------------------------------------
            */

            $message = Message::create([

                'sender_id' =>
                    $sender->id,

                'receiver_id' =>
                    null,

                'chat_group_id' =>
                    $group->id,

                'message' =>
                    $messageText !== ''
                        ? $messageText
                        : null,

                'file' =>
                    $filePath,

                'is_delivered' =>
                    true,

                'delivered_at' =>
                    now(),

                'is_read' =>
                    false,

                'read_at' =>
                    null,
            ]);


            $message->load([
                'sender',
                'group',
            ]);


            /*
            |--------------------------------------------------------------------------
            | BROADCAST
            |--------------------------------------------------------------------------
            */

            event(
                new MessageSent($message)
            );


            /*
            |--------------------------------------------------------------------------
            | NOTIFY GROUP MEMBERS
            |--------------------------------------------------------------------------
            */

            $members = $group
                ->members()
                ->with('user')
                ->where(
                    'user_id',
                    '!=',
                    $sender->id
                )
                ->get();


            foreach ($members as $member) {

                if (!$member->user) {
                    continue;
                }


                try {

                    $member->user->notify(
                        new NewMessageNotification(
                            $messageText !== ''
                                ? $messageText
                                : '📎 Attachment',

                            $sender->id,

                            $sender->name,

                            $member->user->role,

                            $group->id,

                            $group->name
                        )
                    );

                } catch (\Throwable $e) {

                    report($e);
                }
            }


            return $this->redirectToChat(
                $sender,
                'group',
                $group->id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | DIRECT MESSAGE
        |--------------------------------------------------------------------------
        */

        if (!$request->filled('receiver_id')) {

            if ($filePath) {
                Storage::disk('public')
                    ->delete($filePath);
            }

            return back()->with(
                'error',
                'Please select a recipient.'
            );
        }


        $receiver = User::findOrFail(
            $request->receiver_id
        );


        /*
        |--------------------------------------------------------------------------
        | SECURITY
        |--------------------------------------------------------------------------
        */

        if (
            $sender->id ===
            $receiver->id
        ) {

            if ($filePath) {
                Storage::disk('public')
                    ->delete($filePath);
            }

            return back()->with(
                'error',
                'You cannot message yourself.'
            );
        }


        if (
            !$this->canChatWith(
                $sender,
                $receiver
            )
        ) {

            if ($filePath) {
                Storage::disk('public')
                    ->delete($filePath);
            }

            return back()->with(
                'error',
                'Direct chat is only allowed between Admin ↔ Dean and Admin ↔ Cadet.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | CREATE DIRECT MESSAGE
        |--------------------------------------------------------------------------
        */

        $message = Message::create([

            'sender_id' =>
                $sender->id,

            'receiver_id' =>
                $receiver->id,

            'chat_group_id' =>
                null,

            'message' =>
                $messageText !== ''
                    ? $messageText
                    : null,

            'file' =>
                $filePath,

            'is_delivered' =>
                true,

            'delivered_at' =>
                now(),

            'is_read' =>
                false,

            'read_at' =>
                null,
        ]);


        $message->load([
            'sender',
            'receiver',
        ]);


        /*
        |--------------------------------------------------------------------------
        | BROADCAST
        |--------------------------------------------------------------------------
        */

        event(
            new MessageSent($message)
        );


        /*
        |--------------------------------------------------------------------------
        | NOTIFICATION
        |--------------------------------------------------------------------------
        */

        try {

            $receiver->notify(
                new NewMessageNotification(
                    $messageText !== ''
                        ? $messageText
                        : '📎 Attachment',
                    $sender->id,
                    $sender->name,
                    $receiver->role
                )
            );

        } catch (\Throwable $e) {

            report($e);
        }


        return $this->redirectToChat(
            $sender,
            'direct',
            $receiver->id
        );
    }

/*
|--------------------------------------------------------------------------
| CREATE / OPEN BATCH GROUP
|--------------------------------------------------------------------------
*/

public function createGroup(Request $request)
{
    $user = Auth::user();

    /*
    |--------------------------------------------------------------------------
    | ONLY ADMIN / DEAN CAN CREATE GROUPS
    |--------------------------------------------------------------------------
    */

    if (
        !$this->isAdmin($user) &&
        !$this->isDean($user)
    ) {
        abort(403);
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    $request->validate([
        'batch_id' => [
            'required',
            'integer',
            'exists:batches,id',
        ],

        'name' => [
            'required',
            'string',
            'max:100',
        ],

        'description' => [
            'nullable',
            'string',
            'max:1000',
        ],

        'avatar' => [
            'nullable',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:5120',
        ],
    ]);

    /*
    |--------------------------------------------------------------------------
    | FIND BATCH
    |--------------------------------------------------------------------------
    */

    $batch = Batch::findOrFail(
        $request->batch_id
    );

    /*
    |--------------------------------------------------------------------------
    | CHECK IF THIS BATCH ALREADY HAS A GROUP
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | We check this BEFORE entering the transaction.
    | This prevents returning a RedirectResponse from inside
    | DB::transaction().
    |
    */

    $existingGroup = ChatGroup::where(
        'batch_id',
        $batch->id
    )->first();

    if ($existingGroup) {

        return redirect()
            ->route(
                $this->chatRouteName($user),
                [
                    'type' => 'group',
                    'group_id' => $existingGroup->id,
                ]
            )
            ->with(
                'error',
                "Batch {$batch->batch_year} already has a group chat."
            );
    }

    /*
    |--------------------------------------------------------------------------
    | FIND ALL CADETS BELONGING TO THIS BATCH
    |--------------------------------------------------------------------------
    |
    | Only cadets that already have a user account are added.
    |
    */

    $cadetUserIds = DB::table('cadets')
        ->where(
            'batch_id',
            $batch->id
        )
        ->whereNotNull(
            'user_id'
        )
        ->pluck(
            'user_id'
        )
        ->map(
            fn ($id) => (int) $id
        )
        ->unique()
        ->values()
        ->all();

    /*
    |--------------------------------------------------------------------------
    | CREATOR MUST ALSO BE A MEMBER
    |--------------------------------------------------------------------------
    */

    if (
        !in_array(
            (int) $user->id,
            $cadetUserIds,
            true
        )
    ) {
        $cadetUserIds[] = (int) $user->id;
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE GROUP
    |--------------------------------------------------------------------------
    */

    $group = DB::transaction(
        function () use (
            $request,
            $user,
            $batch,
            $cadetUserIds
        ) {

            /*
            |--------------------------------------------------------------------------
            | DOUBLE-SUBMIT / RACE CONDITION PROTECTION
            |--------------------------------------------------------------------------
            */

            $existingGroup = ChatGroup::query()
                ->where(
                    'batch_id',
                    $batch->id
                )
                ->lockForUpdate()
                ->first();

            if ($existingGroup) {
                return $existingGroup;
            }

            /*
            |--------------------------------------------------------------------------
            | GROUP AVATAR
            |--------------------------------------------------------------------------
            */

            $avatarPath = null;

            if ($request->hasFile('avatar')) {

                $avatarPath = $request
                    ->file('avatar')
                    ->store(
                        'chat_group_avatars',
                        'public'
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | CREATE GROUP
            |--------------------------------------------------------------------------
            */

            $group = ChatGroup::create([
                'batch_id' =>
                    $batch->id,

                'name' =>
                    $request->name,

                'description' =>
                    $request->description,

                'avatar' =>
                    $avatarPath,

                'created_by' =>
                    $user->id,
            ]);

            /*
            |--------------------------------------------------------------------------
            | ADD CREATOR
            |--------------------------------------------------------------------------
            */

            ChatGroupMember::firstOrCreate(
                [
                    'chat_group_id' =>
                        $group->id,

                    'user_id' =>
                        $user->id,
                ],
                [
                    'role' =>
                        'admin',

                    'joined_at' =>
                        now(),
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | ADD ALL BATCH USERS
            |--------------------------------------------------------------------------
            */

            foreach (
                $cadetUserIds as $memberId
            ) {

                if (!$memberId) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | VERIFY USER EXISTS
                |--------------------------------------------------------------------------
                */

                if (
                    !User::where(
                        'id',
                        $memberId
                    )->exists()
                ) {
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | ADD MEMBER
                |--------------------------------------------------------------------------
                */

                ChatGroupMember::firstOrCreate(
                    [
                        'chat_group_id' =>
                            $group->id,

                        'user_id' =>
                            $memberId,
                    ],
                    [
                        'role' =>
                            $memberId ===
                            (int) $user->id
                                ? 'admin'
                                : 'member',

                        'joined_at' =>
                            now(),
                    ]
                );
            }

            return $group;
        }
    );

    /*
    |--------------------------------------------------------------------------
    | REDIRECT TO GROUP
    |--------------------------------------------------------------------------
    */

    return redirect()
        ->route(
            $this->chatRouteName($user),
            [
                'type' =>
                    'group',

                'group_id' =>
                    $group->id,
            ]
        )
        ->with(
            'success',
            "Batch group for {$batch->batch_year} is ready."
        );
}


    /*
    |--------------------------------------------------------------------------
    | ADD GROUP MEMBER
    |--------------------------------------------------------------------------
    */

    public function addMember(
        Request $request,
        ChatGroup $group
    ) {

        $user = Auth::user();


        if (!$this->isGroupAdmin(
            $group,
            $user
        )) {

            abort(403);
        }


        $request->validate([

            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],

        ]);


        ChatGroupMember::firstOrCreate(

            [
                'chat_group_id' =>
                    $group->id,

                'user_id' =>
                    $request->user_id,
            ],

            [
                'role' =>
                    'member',

                'joined_at' =>
                    now(),
            ]
        );


        return back()->with(
            'success',
            'Member added to group.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | REMOVE GROUP MEMBER
    |--------------------------------------------------------------------------
    */

    public function removeMember(
        Request $request,
        ChatGroup $group,
        User $member
    ) {

        $user = Auth::user();


        if (!$this->isGroupAdmin(
            $group,
            $user
        )) {

            abort(403);
        }


        if (
            $member->id ===
            $group->created_by
        ) {

            return back()->with(
                'error',
                'The group creator cannot be removed.'
            );
        }


        $group
            ->members()
            ->where(
                'user_id',
                $member->id
            )
            ->delete();


        return back()->with(
            'success',
            'Member removed from group.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | LEAVE GROUP
    |--------------------------------------------------------------------------
    */

    public function leaveGroup(
        ChatGroup $group
    ) {

        $user = Auth::user();


        $member =
            $group
                ->members()
                ->where(
                    'user_id',
                    $user->id
                )
                ->first();


        if (!$member) {

            return back()->with(
                'error',
                'You are not a member of this group.'
            );
        }


        if (
            $group->created_by ===
            $user->id
        ) {

            return back()->with(
                'error',
                'The group creator cannot leave the group.'
            );
        }


        $member->delete();


        return redirect()
            ->route(
                $this->chatRouteName($user)
            )
            ->with(
                'success',
                'You left the group.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE GROUP
    |--------------------------------------------------------------------------
    */

    public function deleteGroup(
        ChatGroup $group
    ) {

        $user = Auth::user();


        if (
            $group->created_by !==
            $user->id
        ) {

            abort(403);
        }


        if ($group->avatar) {

            Storage::disk('public')
                ->delete(
                    $group->avatar
                );
        }


        $group->delete();


        return redirect()
            ->route(
                $this->chatRouteName($user)
            )
            ->with(
                'success',
                'Group deleted successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | MARK DIRECT CHAT AS READ
    |--------------------------------------------------------------------------
    */

    public function markAsRead(
        Request $request
    ) {

        $user = Auth::user();


        $request->validate([

            'receiver_id' => [
                'required',
                'integer',
                'exists:users,id',
            ],

        ]);


        $receiver = User::findOrFail(
            $request->receiver_id
        );


        if (
            !$this->canChatWith(
                $user,
                $receiver
            )
        ) {

            abort(403);
        }


        Message::query()
            ->whereNull('chat_group_id')
            ->where(
                'sender_id',
                $receiver->id
            )
            ->where(
                'receiver_id',
                $user->id
            )
            ->where(
                'is_read',
                false
            )
            ->update([

                'is_read' =>
                    true,

                'read_at' =>
                    now(),
            ]);


        return response()->json([
            'success' => true,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | GET CONTACTS
    |--------------------------------------------------------------------------
    */

    private function getContacts(
        User $user
    ) {

        if ($this->isDean($user)) {

            return User::query()
                ->where(
                    'role',
                    'admin'
                )
                ->where(
                    'id',
                    '!=',
                    $user->id
                )
                ->orderBy('name')
                ->get();
        }


        if ($this->isAdmin($user)) {

            return User::query()
                ->whereIn(
                    'role',
                    [
                        'dean',
                        'cadet',
                    ]
                )
                ->where(
                    'id',
                    '!=',
                    $user->id
                )
                ->orderBy('name')
                ->get();
        }


        if ($this->isCadet($user)) {

            return User::query()
                ->where(
                    'role',
                    'admin'
                )
                ->where(
                    'id',
                    '!=',
                    $user->id
                )
                ->orderBy('name')
                ->get();
        }


        return collect();
    }


    /*
    |--------------------------------------------------------------------------
    | DIRECT CHAT PERMISSION
    |--------------------------------------------------------------------------
    */

    private function canChatWith(
        User $sender,
        User $receiver
    ): bool {

        $senderRole =
            strtolower(
                trim(
                    (string) $sender->role
                )
            );


        $receiverRole =
            strtolower(
                trim(
                    (string) $receiver->role
                )
            );


        return (

            (
                $senderRole === 'admin' &&
                $receiverRole === 'dean'
            )

            ||

            (
                $senderRole === 'dean' &&
                $receiverRole === 'admin'
            )

            ||

            (
                $senderRole === 'admin' &&
                $receiverRole === 'cadet'
            )

            ||

            (
                $senderRole === 'cadet' &&
                $receiverRole === 'admin'
            )

        );
    }


    /*
    |--------------------------------------------------------------------------
    | GROUP ADMIN
    |--------------------------------------------------------------------------
    */

    private function isGroupAdmin(
        ChatGroup $group,
        User $user
    ): bool {

        return
            $group->created_by ===
            $user->id
            ||
            $group
                ->members()
                ->where(
                    'user_id',
                    $user->id
                )
                ->where(
                    'role',
                    'admin'
                )
                ->exists();
    }


    /*
    |--------------------------------------------------------------------------
    | ROLE HELPERS
    |--------------------------------------------------------------------------
    */

    private function isAdmin(
        User $user
    ): bool {

        return strtolower(
            trim(
                (string) $user->role
            )
        ) === 'admin';
    }


    private function isDean(
        User $user
    ): bool {

        return strtolower(
            trim(
                (string) $user->role
            )
        ) === 'dean';
    }


    private function isCadet(
        User $user
    ): bool {

        return strtolower(
            trim(
                (string) $user->role
            )
        ) === 'cadet';
    }


    /*
    |--------------------------------------------------------------------------
    | CHAT ROUTE
    |--------------------------------------------------------------------------
    */

    private function chatRouteName(
        User $user
    ): string {

        return $this->isDean($user)
            ? 'superadmin.chat'
            : 'chat.index';
    }


    /*
    |--------------------------------------------------------------------------
    | REDIRECT CHAT
    |--------------------------------------------------------------------------
    */

    private function redirectToChat(
        User $user,
        string $type,
        int $id
    ) {

        if ($type === 'group') {

            return redirect()->route(
                $this->chatRouteName($user),
                [
                    'type' =>
                        'group',

                    'group_id' =>
                        $id,
                ]
            );
        }


        return redirect()->route(
            $this->chatRouteName($user),
            [
                'type' =>
                    'direct',

                'receiver_id' =>
                    $id,
            ]
        );
    }
}