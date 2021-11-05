<div class="d-flex align-items-center">
    <div class="symbol symbol-40px symbol-circle me-2">
        <span
            class="symbol-label bg-primary text-inverse-primary fw-bolder">{{ strtoupper($client->user->name[0]) }}</span>
        {{-- <img src="http://127.0.0.1:8000/demo1/media/avatars/150-11.jpg" alt=""> --}}
    </div>
    <div class="d-flex justify-content-start flex-column">
        @if (isset($link))
            <a href="{{ "/project/detail/$project->id" }}"
                class="text-dark fw-bolder text-hover-primary fs-6">{{ $client->user->name }}
            </a>
        @else
            <a href="#" class="text-dark fw-bolder text-hover-primary fs-6 ">{{ $client->user->name }}
            </a>
        @endif
        <span class="text-muted fw-bold text-muted d-block fs-7">
            @php
                echo mailing($client->user->email, ['class' => 'text-gray-600', 'data-mail' => true, 'mail' => $client->user->email, 'title' => trans('lang.mail-to')]);
            @endphp
        </span>
        @if ($client->user->phone)
            <div class="d-flex align-items-center flex-wrap">
            <i class="fas fa-phone-alt"></i> &nbsp;<span id="phone-{{ $client->user->id }}" class="text-gray-600"> {{ $client->user->phone }}</span>
            @if ($for_user->is_commercial())
                <a class="btn btn-icon btn-sm btn-light " style="width: 20px;height:17px" data-clipboard-target="#phone-{{ $client->user->id }}">
                    {!! theme()->getSvgIcon('icons/duotune/general/gen054.svg') !!}
                </a>
            @endif
        </div>
        @endif
        
    </div>
</div>
@if ($client->user->phone && $for_user->is_commercial() )
<script>
    $(document).ready(function() {
        var target = document.getElementById('phone-{{ $client->user->id }}');
        var button = target.nextElementSibling;
        clipboard = new ClipboardJS(button, {
            target: target,
            text: function() {
                return target.innerHTML;
            }
        });
        clipboard.on('success', function(e) {
            var checkIcon = button.querySelector('.bi.bi-check');
            var svgIcon = button.querySelector('.svg-icon');
            if (checkIcon) {
                return;
            }
            toastr.success('{{trans("lang.copied")}}')
            checkIcon = document.createElement('i');
            checkIcon.classList.add('bi');
            checkIcon.classList.add('bi-check');
            checkIcon.classList.add('fs-1x');
            button.appendChild(checkIcon);
            const classes = ['text-primary', 'fw-boldest'];
            target.classList.add(...classes);
            button.classList.add('btn-primary');
            svgIcon.classList.add('d-none');
            setTimeout(function() {
                svgIcon.classList.remove('d-none');
                button.removeChild(checkIcon);
                target.classList.remove(...classes);
                button.classList.remove('btn-primary');
            }, 3000)
        });
    })
</script>
@endif
