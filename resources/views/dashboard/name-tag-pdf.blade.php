{{-- <div style="margin-top: 20px; display: flex; justify-content: center;"> --}}
    <table style="width: 100%; background: #f0f0f0; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
      <tr>
          <td style="background: #222; color: #fff; text-align: center; padding: 20px;border-radius: 10px 10px 0 0;">
              <h4 style="margin: 0;">Lions MD 307 Convention<br>Indonesia</h4>
          </td>
      </tr>
      <tr>
          <td style="text-align: center; padding: 20px; position: relative;">
              
              {{-- <img src="{{ asset('/storage/qrcodes/' . $uuid->uuid. ".png") }}" class="img-fluid" alt="" style="margin-bottom: 10px;"> --}}
              <img src="{{ asset('storage/qrcodes/' . $uuid->uuid . '.png') }}" class="img-fluid" alt="" style="margin-bottom: 10px;">
              {{-- <img src="{{ $message->embed($qrCodePath) }}" alt="QR Code"> --}}
              <h4 style="font-size: 30px; color: black; margin-top: 10px;">{{ $member->full_name }}</h4>
              <div style="color: #777; margin-bottom: 10px;">{{ $member->title ?? "-" }}</div>
              <!-- Add the address and other info here -->
              
          </td>
      </tr>
    </table>  
    
    @push('additional-styles')
        @once
            <link rel="stylesheet" href="{{ asset('css/email.css') }}">
        @endonce
    @endpush