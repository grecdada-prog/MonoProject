<h2 class="font-bold mb-4">Produits en rupture</h2>

@if($products->count() === 0)
    <p class="text-gray-500 text-sm">Aucune rupture actuellement.</p>
@else
    <ul class="space-y-2">
        @foreach($products as $p)
            <li class="flex justify-between text-sm">
                <span>{{ $p->name }}</span>
                <span class="text-red-600 font-bold">{{ $p->current_stock }}</span>
            </li>
        @endforeach
    </ul>
@endif
