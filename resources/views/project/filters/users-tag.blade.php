
<input class="form-control form-control-white" style="font-family: Arial,FontAwesome;" autocomplete="off" name="user" value="" id="user" placeholder="Dessinateur"/>
<input type="hidden" id="user_id" value=""/>

{{-- @section('scripts') --}}
    
<script>
    $(document).ready(function() {
        var input = document.querySelector("#user");
        function tagTemplate(tagData) {
            return `
                    <tag title="${(tagData.title || tagData.email)}"
                            contenteditable='false'
                            spellcheck='false'
                            tabIndex="-1"
                            class="${this.settings.classNames.tag} ${tagData.class ? tagData.class : ""}"
                            ${this.getAttributes(tagData)}>
                        <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
                        <div class="d-flex align-items-center">
                            <div class='tagify__tag__avatar-wrap ps-0'>
                                <img onerror="this.style.visibility='hidden'" class="rounded-circle w-25px me-2" src="${tagData.avatar}">
                            </div>
                            <span class='tagify__tag-text'>${tagData.name}</span>
                        </div>
                    </tag>
                `
        }
        function suggestionItemTemplate(tagData) {
            return `
                    <div class='tagify__dropdown__item' tabindex="0" role="option">
                        ${tagData.avatar ? `
                            <b class='tagify__dropdown__item__avatar-wrap me-2'>
                                <img onerror="this.style.visibility='hidden'"class="rounded-circle w-25px me-2" src="${tagData.avatar}">
                            </b>` : ''
                        }
                        <strong>${tagData.name}</strong>
                    </div>
                `
        }
        var tagify = new Tagify(input, {
            tagTextProp: 'name',
            enforceWhitelist: true,
            keepInvalidTags: false,
            skipInvalid: true,
            whitelist: @json($users),
            maxTags: 1,
            dropdown: {
                maxItems: @json(count($users)),
                closeOnSelect: true,
                enabled: 0,
                classname: 'tagify__inline__suggestions',
                searchKeys: ['name', 'email']
            },
            templates: {
                tag: tagTemplate,
                dropdownItem: suggestionItemTemplate
            },
        });
        tagify.on('add', onAddTag)
        tagify.on('remove', removeTag)
        function onAddTag(e) {
            var value = e.detail.data.value
            !value ? $("#user_id").val(0) :   tagify.removeAllTags(); $("#user_id").val(value);
        }
        function removeTag(e) {
            $("#user_id").val(0);
        }
    })
</script>
{{-- @endsection --}}
