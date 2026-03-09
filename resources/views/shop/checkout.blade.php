@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 py-10">

<div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl p-8">

<h2 class="text-2xl font-bold text-center mb-8">
Pilih Metode Pembayaran
</h2>


<h3 class="text-lg font-semibold mb-4">
QRIS (Scan Semua E-Wallet)
</h3>

<form action="{{ route('payment.process') }}" method="POST">
@csrf
<input type="hidden" name="payment_method" value="qris">

<button type="submit"
class="w-full border rounded-lg p-4 hover:shadow-md transition mb-6">

<div class="flex items-center gap-4">

<img 
src="https://seeklogo.com/images/Q/qris-logo-4E9B9F3F23-seeklogo.com.png"
class="h-8 object-contain"
/>

<div class="text-left">
<div class="font-semibold">QRIS</div>
<div class="text-sm text-gray-500">
Scan menggunakan semua aplikasi pembayaran
</div>
</div>

</div>

</button>

</form>


<h3 class="text-lg font-semibold mb-4">
E-Wallet
</h3>


<!-- DANA -->
<form action="{{ route('payment.process') }}" method="POST">
@csrf
<input type="hidden" name="payment_method" value="qris">

<button type="submit"
class="w-full border rounded-lg p-4 hover:shadow-md transition mb-3">

<div class="flex items-center gap-4">

<img 
src="https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_dana_blue.svg"
class="h-7"
/>

<span class="font-medium">
DANA
</span>

</div>

</button>

</form>



<!-- OVO -->
<form action="{{ route('payment.process') }}" method="POST">
@csrf
<input type="hidden" name="payment_method" value="qris">

<button type="submit"
class="w-full border rounded-lg p-4 hover:shadow-md transition mb-3">

<div class="flex items-center gap-4">

<img 
src="https://upload.wikimedia.org/wikipedia/commons/e/eb/Logo_ovo_purple.svg"
class="h-7"
/>

<span class="font-medium">
OVO
</span>

</div>

</button>

</form>



<!-- GOPAY -->
<form action="{{ route('payment.process') }}" method="POST">
@csrf
<input type="hidden" name="payment_method" value="qris">

<button type="submit"
class="w-full border rounded-lg p-4 hover:shadow-md transition mb-6">

<div class="flex items-center gap-4">

<img 
src="https://upload.wikimedia.org/wikipedia/commons/8/86/Gopay_logo.svg"
class="h-7"
/>

<span class="font-medium">
GoPay
</span>

</div>

</button>

</form>



<h3 class="text-lg font-semibold mb-4">
Virtual Account Bank
</h3>


<!-- BCA -->
<form action="{{ route('payment.process') }}" method="POST">
@csrf
<input type="hidden" name="payment_method" value="va_bca">

<button type="submit"
class="w-full border rounded-lg p-4 hover:shadow-md transition mb-3">

<div class="flex items-center gap-4">

<img 
src="https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg"
class="h-7"
/>

<span class="font-medium">
BCA Virtual Account
</span>

</div>

</button>

</form>



<!-- BNI -->
<form action="{{ route('payment.process') }}" method="POST">
@csrf
<input type="hidden" name="payment_method" value="va_bni">

<button type="submit"
class="w-full border rounded-lg p-4 hover:shadow-md transition mb-3">

<div class="flex items-center gap-4">

<img 
src="https://upload.wikimedia.org/wikipedia/commons/5/55/BNI_logo.svg"
class="h-7"
/>

<span class="font-medium">
BNI Virtual Account
</span>

</div>

</button>

</form>



<!-- BRI -->
<form action="{{ route('payment.process') }}" method="POST">
@csrf
<input type="hidden" name="payment_method" value="va_bri">

<button type="submit"
class="w-full border rounded-lg p-4 hover:shadow-md transition mb-3">

<div class="flex items-center gap-4">

<img 
src="https://upload.wikimedia.org/wikipedia/commons/2/2e/BRI_2020.svg"
class="h-7"
/>

<span class="font-medium">
BRI Virtual Account
</span>

</div>

</button>

</form>



<!-- Mandiri -->
<form action="{{ route('payment.process') }}" method="POST">
@csrf
<input type="hidden" name="payment_method" value="va_mandiri">

<button type="submit"
class="w-full border rounded-lg p-4 hover:shadow-md transition">

<div class="flex items-center gap-4">

<img 
src="https://upload.wikimedia.org/wikipedia/commons/a/ad/Bank_Mandiri_logo_2016.svg"
class="h-7"
/>

<span class="font-medium">
Mandiri Virtual Account
</span>

</div>

</button>

</form>


</div>

</div>

@endsection