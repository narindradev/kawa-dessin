<div class="text-gray-400 action-message">
    @if ($message->sender_id == $for_user->id)
        <span style="cursor :pointer " class="delete-message"  data-message-id="{{ "me-".$message->id }}">Supprimer</span> |
    @endif
    <span style="cursor :pointer " class="delete-message" data-message-id="{{ $message->id }}">
        Supprimer  
        @if ($message->sender_id == $for_user->id)
        pour moi
        @endif  </span>
</div>

