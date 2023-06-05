<span>{{ __('made by ') }}</span>
<a href="{{ route('profile.show', $pl->user) }}" class="text-gray-800 underline">{{ $pl->user->name }}</a>
<span>{{ __(' on ') . Carbon\Carbon::parse($pl->created_at)->format('Y/m/d') }}</span>
