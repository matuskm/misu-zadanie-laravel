<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title> {{ config('app.name') }} @yield('page_title')</title>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    </head>
    <body>
        <div id='app' class="overflow-auto">
            <div id="container">
                <div class="col-8 m-5">
                    <div class="card">
                        <div class="card-body">
                            <p class="h4">Produkt s najnižšou cenou</p>
                            <table class="table table-striped table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Produkt</th>
                                        <th scope="col">Nová cena</th>
                                        <th scope="col">Stará cena</th>
                                        <th scope="col">Znížená o</th>
                                        <th scope="col">E-shop</th>
                                        <th scope="col">E-shop link</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">{{ $lowest_price->product->name }}</th>
                                        <th>{{ $lowest_price->new_price }}€</th>
                                        <th>{{ $lowest_price->old_price }}€</th>
                                        <th>{{ $lowest_price->percentage_diff }}%</th>
                                        <th>{{ $lowest_price->product->eshop->name }}</th>
                                        <th><a href="{{ $lowest_price->product->eshop->url }}" target="_blank">{{ $lowest_price->product->eshop->url }}</th>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-8 m-5">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Produkt</th>
                                <th scope="col">Nová cena</th>
                                <th scope="col">Stará cena</th>
                                <th scope="col">Znížená o</th>
                                <th scope="col">E-shop</th>
                                <th scope="col">E-shop link</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ( $data as $item )
                                <tr>
                                    <th scope="row">{{ $item->product->name }}</th>
                                    <th>{{ $item->new_price }}€</th>
                                    <th>{{ $item->old_price }}€</th>
                                    <th>{{ $item->percentage_diff }}%</th>
                                    <th>{{ $item->product->eshop->name }}</th>
                                    <th><a href="{{ $item->product->eshop->url }}" target="_blank">{{ $item->product->eshop->url }}</th>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination-info">
                        {{ $data->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
