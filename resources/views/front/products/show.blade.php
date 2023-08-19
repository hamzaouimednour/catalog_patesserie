<div class="col-md-6">
	<!--img/ name / des-->
	<img src="/thumbs/{{$product->productImgs->first()->img}}" class="img-fluid img">
	<hr>
	<div class="name text-center">
		{{$product->name}}
	</div>
	<hr>
	<div class="description text-center">
		{{$product->description}}
	</div>
	<hr>
	<!--formulaire-->
	<div class="text-center">
		<span class="price"
			id="product-price">{{ ($product->default_price) ? number_format($product->default_price, 3) : number_format($productParfums->where('default', 1)->first()->default_price, 3) }}</span>
		<span class="tag">DT</span>
		<hr>
	</div>
</div>


<div class="col-md-6">
	<hr>
	<div class="number">
		{{-- <div class="number text-center">
			<span class="minus">-</span>
			<input class="float-num" name="qty" type="text" id="items-qty" value="1" />
			<span class="plus">+</span>
		</div> --}}
		<div class="number text-center">
			<button class="minus-btn add" type="button" name="button">
				<img src="https://designmodo.com/demo/shopping-cart/minus.svg" alt="" />
			</button>
			<input type="text" id="items-qty" class="keyboard text-center" value="1" style="height: 10%;"/>
			<button class="plus-btn add" type="button" name="button">
				<img src="https://designmodo.com/demo/shopping-cart/plus.svg" alt="" />
			</button>
		</div>
	</div>
	<hr>
	<div class="formulaire">

		<form id="cart-form" name="cart-form">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input name="id" value="{{$product->id}}" type="hidden" />
			<div class="form-group row">
				@if ($product->price_by_size)
				<div class="form-group col-md-12">
					<label for="Demention">Dimension</label>
					<select id="Demention" name="dimension" class="form-control select">
						<option value="" disabled selected>Sélectionnez un choix</option>
						@foreach ($product->productSizePrices as $item)
						@if ($item->default)
						@php
						$selected_item = $item->id;
						@endphp
						@endif
						<option value="{{$item->id}}" data-price="{{$item->price * 1000}}"
							{{($item->default) ? 'selected' : NULL}}>{{$item->Size->size_name}}</option>
						@endforeach
					</select>
				</div>
				@endif

				@if(!$product->price_by_size && $product->default_price)
				<div class="form-group col-md-12">
					<label for="prix">Prix</label>
					<select id="prix" name="default_price" class="form-control select" style="pointer-events: none;">
						<option value="{{$product->default_price * 1000}}"
							data-price="{{$product->default_price * 1000}}" selected>
							{{number_format($product->default_price, 3, '.', ',')}} DT</option>
					</select>
				</div>
				@endif


				{{-- START PARFUMS --}}

				@if ($productParfums->isNotEmpty() && $productParfums->first()->price_by_size &&
				$product->price_by_size)
				<div class="form-group col-md-12">
					<label for="Parfums">Parfums</label>
					<select id="Parfums" name="parfums" data-price-size="true" class="form-control select">
						<option value="" disabled selected>Sélectionnez un choix</option>
						@php
						$_dimension_id = $product->productSizePrices->where('id', $selected_item )->first()->size_id;
						foreach ($productParfums as $item) {
						if($item->productComponentPrices->first()->size_id == $_dimension_id){
						echo '<option value="'.$item->component_id.'">'.$item->Component->name.'</option>';
						}
						}
						@endphp
					</select>
					<input type="hidden" name="parfums-price-size" value="1">
				</div>
				@endif

				{{-- in case there is no default prices even by size --}}
				@if ($productParfums->isNotEmpty() && $productParfums->first()->price_by_size &&
				!$product->price_by_size)
				<div class="form-group col-md-12">
					<label for="Demention">Dimension</label>
					<select id="Demention" name="dimension2" data-price-size="true" class="form-control select">
						<option value="" disabled selected>Sélectionnez un choix</option>
						@foreach ($parfums_dimensions->unique('size_id') as $item)
						@php
						if($item->price == $productParfums->where('default', 1)->first()->default_price){
						$_dimension_id = $item->size_id;
						}
						@endphp
						<option value="{{$item->size_id}}" data-price=""
							{{($item->price == $productParfums->where('default', 1)->first()->default_price) ? "selected" : NULL}}>
							{{$item->Size->size_name}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group col-md-12">
					<label for="Parfums">Parfums</label>
					<select id="Parfums" name="parfums" data-price-size="true" class="form-control select">
						<option value="" disabled selected>Sélectionnez un choix</option>
						@php
						foreach ($productParfums as $item) {
						if($item->productComponentPrices->first()->size_id == $_dimension_id){
						echo '<option value="'.$item->component_id. '" '.(($item->default) ? ' selected' : NULL).'>
							'.$item->Component->name.'</option>';
						}
						}
						@endphp
					</select>
					<input type="hidden" name="parfums-price-size" value="1">
				</div>
				@endif

				{{-- parfums not by size --}}
				@if ($productParfums->isNotEmpty() && !$productParfums->first()->price_by_size)
				<div class="form-group col-md-12">
					<label for="Parfums">Parfums</label>
					<select id="Parfums" name="parfums" data-price-size="false" class="form-control select">
						<option value="" disabled selected>Sélectionnez un choix</option>
						@foreach ($productParfums as $parfum)
						<option value="{{$parfum->id}}" data-price="{{$parfum->default_price * 1000}}"
							{{($product->price_by_size) ? NULL : (($parfum->default) ? 'selected' : NULL)}}>
							{{$parfum->Component->name}}</option>
						@endforeach
					</select>
					<input type="hidden" name="parfums-price-size" value="0">
				</div>
				@endif

				{{-- END PARFUMS --}}

				{{-- START DECORS --}}
				{{-- decors not by size --}}
				@if ($productDecors->isNotEmpty() && !$productDecors->first()->price_by_size)
				<div class="form-group col-md-12">
					<label for="Decors">Accessoires Décoratifs</label>
					<select id="Decors" name="decors" data-price-size="false" class="form-control select">
						<option value="" selected>Sélectionnez un choix</option>
						@foreach ($productDecors as $decor)
						<option value="{{$decor->id}}" data-price="{{$decor->default_price * 1000}}">
							{{$decor->Component->name}}</option>
						@endforeach
					</select>
					<input type="hidden" name="decors-price-size" value="0">
				</div>
				@endif

				@if ($productDecors->isNotEmpty() && $productDecors->first()->price_by_size && $product->price_by_size)
				<div class="form-group col-md-12">
					<label for="Decors">Accessoires Décoratifs</label>
					<select id="Decors" name="decors" data-price-size="false" class="form-control select">
						<option value="" selected>Sélectionnez un choix</option>
						@php
						$_dimension_id = $product->productSizePrices->where('id', $selected_item )->first()->size_id;
						foreach ($productDecors as $item) {
						if($item->productComponentPrices->first()->size_id == $_dimension_id){
						echo '<option value="'.$item->component_id.'">'.$item->Component->name.'</option>';
						}
						}
						@endphp
					</select>
					<input type="hidden" name="decors-price-size" value="1">
				</div>
				@endif

				{{-- <pre>{{var_dump($productDecors->where('default', 1))}} --}}
				{{-- in case there is no default prices even by size --}}
				@if ($productDecors->isNotEmpty() && $productDecors->first()->price_by_size && !$product->price_by_size)
				@if ($productParfums->isEmpty() || !$productParfums->first()->price_by_size)
				<div class="form-group col-md-12">
					<label class="">Dimension</label>
					<select class="form-control select" name="dimension2">
						<option value="" disabled selected>Sélectionnez un choix</option>
						@foreach ($decors_dimensions->unique('size_id') as $item)
						@php
						if($item->price == $productDecors->where('default', 1)->first()->default_price){
						$_dimension_id = $item->size_id;
						}
						@endphp
						<option value="{{$item->size_id}}" data-price="">{{$item->Size->size_name}}</option>
						@endforeach
					</select>
				</div>
				@endif

				<div class="form-group col-md-12">
					<label for="Decors">Accessoires Décoratifs</label>
					<select id="Decors" name="decors" data-price-size="true" class="form-control select">
						<option value="" selected>Sélectionnez un choix</option>
						@php
						foreach ($productDecors as $item) {
						if($item->productComponentPrices->first()->size_id == $_dimension_id){
						echo '<option value="'.$item->component_id. '">'.$item->Component->name.'</option>';
						}
						}
						@endphp
					</select>
					<input type="hidden" name="decors-price-size" value="1">
				</div>
				@endif

			</div>

			<div class="form-group col-md-12">
				<label for="msg">Message sur le Plateau (optionnel)</label>
				<textarea class="keyboard form-control" id="default" name="item-msg" rows="3"></textarea>
			</div>

			<div class="row">
				<div class="col-md-6 check">
					<button type="submit" class="btn btn-success" id="cart-add">
						<i class="fa fa-cart-plus"></i>Commander
					</button>
				</div>
				<div class="col-md-6 check">
					<button type="" class="btn btn-danger" data-dismiss="modal">
						<i class="fa fa-times"></i>Annuler
					</button>

				</div>
			</div>

		</form>
	</div>
</div>