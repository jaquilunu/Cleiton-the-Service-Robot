<?php
$nome = $_GET["nome"] ?? "";
$telefone = $_GET["telefone"] ?? "";
$endereco = $_GET["endereco"] ?? "";
$estado = $_GET["estado"] ?? "";
$cep = $_GET["cep"] ?? "";
$cidade = $_GET["cidade"] ?? "";
$quantidade = $_GET["quant"] ?? 0;
$vendaId = $_GET["id"] ?? "0";

class PixPayload
{
    const ID_PAYLOAD_FORMAT_INDICATOR = '00';
    const ID_MERCHANT_ACCOUNT_INFORMATION = '26';
    const ID_MERCHANT_ACCOUNT_INFORMATION_GUI = '00';
    const ID_MERCHANT_ACCOUNT_INFORMATION_KEY = '01';
    const ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION = '02';
    const ID_MERCHANT_CATEGORY_CODE = '52';
    const ID_TRANSACTION_CURRENCY = '53';
    const ID_TRANSACTION_AMOUNT = '54';
    const ID_COUNTRY_CODE = '58';
    const ID_MERCHANT_NAME = '59';
    const ID_MERCHANT_CITY = '60';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE = '62';
    const ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID = '05';
    const ID_CRC16 = '63';

    private $pixKey;
    private $description;
    private $merchantName;
    private $merchantCity;
    private $txid;
    private $amount;

    public function setPixKey($pixKey)
    {
        $this->pixKey = $pixKey;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = substr($description, 0, 25);
        return $this;
    }

    public function setMerchantName($merchantName)
    {
        $this->merchantName = substr($merchantName, 0, 25);
        return $this;
    }

    public function setMerchantCity($merchantCity)
    {
        $this->merchantCity = substr($merchantCity, 0, 15);
        return $this;
    }

    public function setTxid($txid)
    {
        $this->txid = substr($txid, 0, 25);
        return $this;
    }

    public function setAmount($amount)
    {
        $this->amount = number_format((float)$amount, 2, '.', '');
        return $this;
    }

    private function getValue($id, $value)
    {
        $size = str_pad(strlen($value), 2, '0', STR_PAD_LEFT);
        return $id . $size . $value;
    }

    private function getMerchantAccountInformation()
    {
        $gui = $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_GUI, 'br.gov.bcb.pix');
        $key = $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_KEY, $this->pixKey);
        $description = $this->description
            ? $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION_DESCRIPTION, $this->description)
            : '';

        return $this->getValue(self::ID_MERCHANT_ACCOUNT_INFORMATION, $gui . $key . $description);
    }

    private function getAdditionalDataFieldTemplate()
    {
        $txid = $this->getValue(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE_TXID, $this->txid);
        return $this->getValue(self::ID_ADDITIONAL_DATA_FIELD_TEMPLATE, $txid);
    }

    public function getPayload()
    {
        $payload = $this->getValue(self::ID_PAYLOAD_FORMAT_INDICATOR, '01') .
            $this->getMerchantAccountInformation() .
            $this->getValue(self::ID_MERCHANT_CATEGORY_CODE, '0000') .
            $this->getValue(self::ID_TRANSACTION_CURRENCY, '986') .
            ($this->amount ? $this->getValue(self::ID_TRANSACTION_AMOUNT, $this->amount) : '') .
            $this->getValue(self::ID_COUNTRY_CODE, 'BR') .
            $this->getValue(self::ID_MERCHANT_NAME, $this->merchantName) .
            $this->getValue(self::ID_MERCHANT_CITY, $this->merchantCity) .
            $this->getAdditionalDataFieldTemplate();

        return $payload . $this->getCRC16($payload);
    }

    private function getCRC16($payload)
    {
        $payload .= self::ID_CRC16 . '04';
        $polynomial = 0x1021;
        $result = 0xFFFF;

        for ($offset = 0; $offset < strlen($payload); $offset++) {
            $result ^= (ord($payload[$offset]) << 8);
            for ($bitwise = 0; $bitwise < 8; $bitwise++) {
                if (($result <<= 1) & 0x10000) {
                    $result ^= $polynomial;
                }
                $result &= 0xFFFF;
            }
        }

        return self::ID_CRC16 . '04' . strtoupper(dechex($result));
    }
}

$pix = (new PixPayload())
    ->setPixKey('11786862565')
    ->setDescription('Biotrade')
    ->setMerchantName('Joao Lucas Souza')
    ->setMerchantCity('Salvador')
    ->setAmount('10.70')
    ->setTxid('TXID123');

$payload = $pix->getPayload();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Pix</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        .qrcode-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }
        .progress-bar {
            width: 100%;
            height: 20px;
            background-color: #ccc;
            border-radius: 10px;
            overflow: hidden;
            margin-top: 20px;
        }
        .progress-bar-inner {
            height: 100%;
            width: 100%;
            background-color: red;
            transition: width 1s linear;
        }
       
        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            cursor: pointer;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .floating-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>QR Code Pix</h1>
    <div class="qrcode-container" id="qrcode"></div>
    <p>
        <strong>Código Pix:</strong>
        <textarea id="pixCode" readonly style="width: 90%; height: 100px;"><?php echo $payload; ?></textarea>
    </p>
    <button onclick="copyPixCode()">Copiar Código</button>
    <div class="progress-bar">
        <div class="progress-bar-inner" id="progressBar"></div>
    </div>
    
    <!-- Botão flutuante -->
    <?php
$link = "pag_notafisc.php?venda_id=" . $vendaId.
        "&nome=" . $nome .
        "&telefone=" . $telefone .
        "&endereco=" . $endereco .
        "&estado=" . $estado .
        "&cep=" . $cep .
        "&cidade=" . $cidade .
        "&quantidade=" . $quantidade;
?>
<button class="floating-button" onclick="location.href='<?= $link ?>'">Nota</button>

    <script>
        // Gerar o QR Code
        const payload = "<?php echo $payload; ?>";
        const qrcode = new QRCode(document.getElementById("qrcode"), {
            text: payload,
            width: 256,
            height: 256,
        });

        // Função para copiar o código Pix
        function copyPixCode() {
            const pixCode = document.getElementById('pixCode');
            pixCode.select();
            document.execCommand('copy');
            alert('Código Pix copiado para a área de transferência!');
        }

        // Timer para recarregar a página com barra de progresso
        const totalTime = 300; // 5 minutos em segundos
        let timeLeft = totalTime;
        const progressBar = document.getElementById('progressBar');

        function updateProgressBar() {
            timeLeft--;
            const percentage = (timeLeft / totalTime) * 100;
            progressBar.style.width = percentage + '%';
            if (timeLeft <= 0) {
                location.reload();
            }
        }

        setInterval(updateProgressBar, 1000);
    </script>
</body>
</html>

