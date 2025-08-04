@props(['url'])
<tr>
    <td class="header">
        <a  style="display: inline-block;">
            @if (trim($slot) === 'Laravel')
            <img src="https://himtech-2025.vercel.app/images/logo.png" alt="Logo" style="height: 150px;">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
