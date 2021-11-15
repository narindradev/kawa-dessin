<div class="text-gray-400 action-message">
    @if ($my_message)
        <span style="cursor :pointer " class="delete-message"  data-message-id="{{ "me-".$message->id }}">Supprimer</span> |
    @endif
    <span style="cursor :pointer " class="delete-message" data-message-id="{{ $message->id }}">
        Supprimer  
        @if ($my_message)
            pour moi
        @endif  </span>
</div>

