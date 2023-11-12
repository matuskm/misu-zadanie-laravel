@include('emails.components.header')

<tbody>
    <tr>
        <td colspan="3" style="padding: 10px 15px 10px 15px; line-height: 30px; font-family: Calibri; font-size: 16px;">
            Dobrý deň,<br>
            posielame Vám notifikáciu o najnižšej cene <strong>{{ $data['new_price'] }}€</strong> produktu <strong>{{ $data['product']['name'] }}</strong>
            v eshope <strong>{{ $data['product']['eshop']['name'] }}</strong>
            (<a href="{{ $data['product']['eshop']['url'] }}" targer="_blank">{{ $data['product']['eshop']['url'] }}</a>).<br>
            Pôvodna cena bola <strong>{{ $data['old_price'] }}€</strong>, zníženie bolo o <strong>{{ $data['percentage_diff'] }}%.</strong>
        </td>
    </tr>
</tbody>

@include('emails.components.footer')


