<div class="space-y-6">
    @forelse ($orders as $order)
        <div class="bg-gray-50 rounded-lg p-4">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-bold">Order #{{ $order->id }}</h3>
                    <p class="text-sm text-gray-500">Placed on: {{ $order->created_at->format('M d, Y') }}</p>
                </div>
                <p class="text-lg font-bold">Total: ${{ number_format($order->total, 2) }}</p>
            </div>
            <div class="mt-4 border-t pt-4">
                @foreach($order->items as $item)
                    <div class="flex justify-between items-center mb-2">
                        <div>
                            <p class="font-semibold">{{ $item->product->title }} (x{{ $item->quantity }})</p>
                            <p class="text-sm text-gray-600">Sold by: {{ $item->product->seller->name }}</p>
                        </div>
                        <div class="text-right">
                           <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($item->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                            @if($item->status == 'accepted') bg-blue-100 text-blue-800 @endif
                            @if($item->status == 'shipping') bg-indigo-100 text-indigo-800 @endif
                            @if($item->status == 'completed') bg-green-100 text-green-800 @endif">
                            {{ ucfirst($item->status) }}
                           </span>
                           @if($item->status == 'shipping')
                            <form action="{{ route('buyer.orders.update', $item) }}" method="POST" class="mt-2">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="text-xs font-medium text-green-600 hover:text-green-900">Mark as Received</button>
                            </form>
                           @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <p class="text-center text-gray-500">You have not placed any orders yet.</p>
    @endforelse
</div>
