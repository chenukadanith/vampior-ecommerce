<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order #</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Shipping To</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($orderItems as $item)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->order->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->product->title }} (x{{ $item->quantity }})</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            @if($item->status == 'pending') bg-yellow-100 text-yellow-800 @endif
                            @if($item->status == 'accepted') bg-blue-100 text-blue-800 @endif
                            @if($item->status == 'shipping') bg-indigo-100 text-indigo-800 @endif
                            @if($item->status == 'completed') bg-green-100 text-green-800 @endif">
                            {{ ucfirst($item->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $item->order->shipping_name }}<br>
                        {{ $item->order->shipping_address }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <form action="{{ route('seller.orders.update', $item) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <select name="status" class="text-sm rounded-md border-gray-300" onchange="this.form.submit()">
                                <option value="pending" @if($item->status == 'pending') selected @endif>Pending</option>
                                <option value="accepted" @if($item->status == 'accepted') selected @endif>Accept</option>
                                <option value="shipping" @if($item->status == 'shipping') selected @endif>Ship</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">You have no orders yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
