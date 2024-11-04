<!DOCTYPE html>
<html>
<head>
    <title>Termo de Autorização de Uso de Imagem - StudioRP</title>
</head>
<body>
    <h2 style="text-align: center;">Termo de Autorização de Uso de Imagem</h2>

    <p><strong>Cliente:</strong> {{ $term->client->name }}</p>
    <p><strong>Data:</strong> {{ $term->term_date }}</p>
    
    <p>
        Eu, <strong>{{ $term->client->name }}</strong>, autorizo o <strong>StudioRP</strong> a utilizar as imagens capturadas durante a sessão de fotografia realizada {{ $term->term_date }} para fins de divulgação e promoção de seus serviços.
    </p>

    <p>As imagens poderão ser utilizadas em redes sociais, site institucional e outras plataformas de comunicação digital do StudioRP, exclusivamente para fins de divulgação, sem fins comerciais diretos.</p>
    
    <p>Esta autorização respeita o <strong>Artigo 79.º do Código Civil Português</strong> e o <strong>Regulamento Geral sobre a Proteção de Dados (RGPD - Regulamento (UE) 2016/679)</strong>, garantindo o direito à revogação da autorização mediante solicitação formal.</p>
    
    <p>
        Declaro que estou ciente dos termos acima e que concedo esta autorização de forma livre e espontânea.
    </p>

    <br><br>

    <!-- Espaço para assinatura e NIF -->
    <div style="margin-top: 50px;">
        <p>________________________________________</p>
        <p><strong>Assinatura do Cliente</strong></p>
        <p><strong>NIF:</strong> ________________________________</p>
    </div>

</body>
</html>
