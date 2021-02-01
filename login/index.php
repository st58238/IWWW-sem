<?php

require_once(__DIR__ . '/../php/core.php');
require_once(__DIR__ . '/../php/html.php');

require_once(__DIR__ . '/../php/pages/login.page.php');

?>
<!DOCTYPE html>
<html lang="cs">
<head>
	<base href="..">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Vinárna - potvrzení objednávky</title>
	<link rel="stylesheet" href="css/main.css">
	<link rel="stylesheet" href="css/cart.css">
	<script src="js/lib.js"></script>
	<style>
		@charset "UTF-8";

		.content {
			flex-direction: row;
			align-items: flex-start;
		}

		.input {
			padding: 5px;
		}

		input[type="submit"] {
			margin-right: 8%;
		}

		.labeled-input {
			justify-content: flex-end;
			padding-right: 8%;
		}

		small {
			margin-top: 8px;
			margin-right: 20px;
		}

		@media only screen and (max-width: 768px) {
			.content {
				flex-direction: row;
				justify-content: center;
				flex-wrap: wrap-reverse;
			}

			.register, .login {
				width: 95%;
			}

			input[type="submit"] {
				width: 57.125%;
				margin: 20px 8% 20px 0;
			}

		}

	</style>
	<script>
		'use strict';

		document.addEventListener('DOMContentLoaded', function() {
			document.querySelector('#regForm').addEventListener('submit', function(e) {
				if (document.querySelector('#passCheck').value !== document.querySelector('#passCheckAgain').value) {
					e.preventDefault();
					document.querySelector('#passCheck').style.border = '2px solid red';
					document.querySelector('#passCheckAgain').style.border = '2px solid red';
				} else {
					document.querySelector('#passCheck').style.border = '';
					document.querySelector('#passCheckAgain').style.border = '';
				}
			});
		});

	</script>
</head>
<body>
	<script>0</script>
	<?php
		echo HEADER;
		echo MAIN_OPEN;
		echo SIDEBAR_LEFT;
	?>
	<main class="content">
		<?php //echo $content; ?>
		<section class="register">
			<form action="login/index.php" method="POST" id="regForm">
				<h2 class="page-title">Registrace</h2>
				<input type="hidden" name="action" value="registration">
				<div class="labeled-input">
					<label for="email">Email<span class="red">*</span>:</label>
					<input type="text" name="email" class="input input-text" required="required">
				</div>
				<div class="labeled-input">
					<label for="password">Heslo<span class="red">*</span>:</label>
					<input type="password" id="passCheck" name="password" class="input input-text" required="required">
				</div>
				<div class="labeled-input">
					<label>Heslo znovu<span class="red">*</span>:</label>
					<input type="password" id="passCheckAgain" class="input input-text" required="required">
				</div>
				<div class="labeled-input">
					<label for="name">Jméno<span class="red">*</span>:</label>
					<input type="text" name="name" class="input input-text" required="required">
				</div>
				<div class="labeled-input">
					<label for="surname">Příjmení<span class="red">*</span>:</label>
					<input type="text" name="surname" class="input input-text" required="required">
				</div>
				<div class="labeled-input">
					<label for="phone">Telefon:</label>
					<input type="text" name="phone" class="input input-text">
				</div>
				<div class="labeled-input">
					<label for="street">Ulice:</label>
					<input type="text" name="street" class="input input-text">
				</div>
				<div class="labeled-input">
					<label for="city">Město:</label>
					<input type="text" name="city" class="input input-text">
				</div>
				<div class="labeled-input">
					<label for="zip">PSČ:</label>
					<input type="text" name="zip" class="input input-text">
				</div>
				<div class="labeled-input">
					<label for="country">Země:</label>
					<select name="country" id="country" class="input input-select">
						<option value="0">Abcházie</option>
						<option value="1">Afghánistán</option>
						<option value="2">Albánie</option>
						<option value="3">Alžírsko</option>
						<option value="4">Andorra</option>
						<option value="5">Angola</option>
						<option value="6">Antigua a Barbuda</option>
						<option value="7">Argentina</option>
						<option value="8">Arménie</option>
						<option value="9">Austrálie</option>
						<option value="10">Ázerbájdžán</option>
						<option value="11">Bahamy</option>
						<option value="12">Bahrajn</option>
						<option value="13">Bangladéš</option>
						<option value="14">Barbados</option>
						<option value="15">Belgie</option>
						<option value="16">Belize</option>
						<option value="17">Bělorusko</option>
						<option value="18">Benin</option>
						<option value="19">Bhútán</option>
						<option value="20">Bolívie</option>
						<option value="21">Bosna a Hercegovina</option>
						<option value="22">Botswana</option>
						<option value="23">Brazílie</option>
						<option value="24">Brunej</option>
						<option value="25">Bulharsko</option>
						<option value="26">Burkina Faso</option>
						<option value="27">Burundi</option>
						<option value="28">Chile</option>
						<option value="29">Chorvatsko</option>
						<option value="30">Čad</option>
						<option value="31">Černá Hora</option>
						<option value="32" selected="selected">Česká Republika</option>
						<option value="33">Čína</option>
						<option value="34">Čínská republika</option>
						<option value="35">Dánsko</option>
						<option value="36">Demokratická republika Kongo</option>
						<option value="37">Dominika</option>
						<option value="38">Dominikánská republika</option>
						<option value="39">Džibutsko</option>
						<option value="40">Egypt</option>
						<option value="41">Ekvádor</option>
						<option value="42">Eritrea</option>
						<option value="43">Estonsko</option>
						<option value="44">Etiopie</option>
						<option value="45">Fidži</option>
						<option value="46">Filipíny</option>
						<option value="47">Finsko</option>
						<option value="48">Francie</option>
						<option value="49">Gabon</option>
						<option value="50">Gambie</option>
						<option value="51">Ghana</option>
						<option value="52">Grenada</option>
						<option value="53">Gruzie</option>
						<option value="54">Guatemala</option>
						<option value="55">Guinea</option>
						<option value="56">Guinea-Bissau</option>
						<option value="57">Guyana</option>
						<option value="58">Haiti</option>
						<option value="59">Honduras</option>
						<option value="60">Indie</option>
						<option value="61">Indonésie</option>
						<option value="62">Irák</option>
						<option value="63">Írán</option>
						<option value="64">Irská republika</option>
						<option value="65">Island</option>
						<option value="66">Itálie</option>
						<option value="67">Izrael</option>
						<option value="68">Jamajka</option>
						<option value="69">Japonsko</option>
						<option value="70">Jemen</option>
						<option value="71">Jihoafrická republika</option>
						<option value="72">Jižní Korea</option>
						<option value="73">Jižní Osetie</option>
						<option value="74">Jižní Súdán</option>
						<option value="75">Jordánsko</option>
						<option value="76">Kambodža</option>
						<option value="77">Kamerun</option>
						<option value="78">Kanada</option>
						<option value="79">Kapverdy</option>
						<option value="80">Katar</option>
						<option value="81">Kazachstán</option>
						<option value="82">Keňa</option>
						<option value="83">Kiribati</option>
						<option value="84">Kolumbie</option>
						<option value="85">Komory</option>
						<option value="86">Konžská republika</option>
						<option value="87">Kosovo</option>
						<option value="88">Kostarika</option>
						<option value="89">Kuba</option>
						<option value="90">Kuvajt</option>
						<option value="91">Kypr</option>
						<option value="92">Kyrgyzstán</option>
						<option value="93">Laos</option>
						<option value="94">Lesotho</option>
						<option value="95">Libanon</option>
						<option value="96">Libérie</option>
						<option value="97">Libye</option>
						<option value="98">Lichtenštejnsko</option>
						<option value="99">Litva</option>
						<option value="100">Lotyšsko</option>
						<option value="101">Lucembursko</option>
						<option value="102">Madagaskar</option>
						<option value="103">Maďarsko</option>
						<option value="104">Makedonie</option>
						<option value="105">Malajsie</option>
						<option value="106">Malawi</option>
						<option value="107">Maledivy</option>
						<option value="108">Mali</option>
						<option value="109">Malta</option>
						<option value="110">Maroko</option>
						<option value="111">Marshallovy ostrovy</option>
						<option value="112">Mauricius</option>
						<option value="113">Mauritánie</option>
						<option value="114">Mexiko</option>
						<option value="115">Mikronésie</option>
						<option value="116">Moldavsko</option>
						<option value="117">Monako</option>
						<option value="118">Mongolsko</option>
						<option value="119">Mosambik</option>
						<option value="120">Myanmar</option>
						<option value="121">Náhorně-karabašská republika</option>
						<option value="122">Namibie</option>
						<option value="123">Nauru</option>
						<option value="124">Německo</option>
						<option value="125">Nepál</option>
						<option value="126">Nigérie</option>
						<option value="127">Nikaragua</option>
						<option value="128">Nizozemsko</option>
						<option value="129">Norsko</option>
						<option value="130">Nový Zéland</option>
						<option value="131">Omán</option>
						<option value="132">Pákistán</option>
						<option value="133">Palau</option>
						<option value="134">Panama</option>
						<option value="135">Papua-Nová Guinea</option>
						<option value="136">Paraguay</option>
						<option value="137">Peru</option>
						<option value="138">Pobřeží slonoviny</option>
						<option value="139">Podněstří</option>
						<option value="140">Polsko</option>
						<option value="141">Portugalsko</option>
						<option value="142">Rakousko</option>
						<option value="143">Rovníková Guinea</option>
						<option value="144">Rumunsko</option>
						<option value="145">Rusko</option>
						<option value="146">Rwanda</option>
						<option value="147">Řecko</option>
						<option value="148">Saharská arabská demokratická republika</option>
						<option value="149">Salvador</option>
						<option value="150">Samoa</option>
						<option value="151">San Marino</option>
						<option value="152">Saúdská Arábie</option>
						<option value="153">Senegal</option>
						<option value="154">Severní Korea</option>
						<option value="155">Severní Kypr</option>
						<option value="156">Seychely</option>
						<option value="157">Sierra Leone</option>
						<option value="158">Singapur</option>
						<option value="159">Slovensko</option>
						<option value="160">Slovinsko</option>
						<option value="161">Somaliland</option>
						<option value="162">Somálsko</option>
						<option value="163">Spojené arabské emiráty</option>
						<option value="164">Spojené státy americké</option>
						<option value="165">Srbsko</option>
						<option value="166">Srí Lanka</option>
						<option value="167">Stát Palestina</option>
						<option value="168">Středoafrická republika</option>
						<option value="169">Súdán</option>
						<option value="170">Surinam</option>
						<option value="171">Svatá Lucie</option>
						<option value="172">Svatý Kryštof a Nevis</option>
						<option value="173">Svatý Tomáš a Princův ostrov</option>
						<option value="174">Svatý Vincenc a Grenadiny</option>
						<option value="175">Svazijsko</option>
						<option value="176">Sýrie</option>
						<option value="177">Šalomounovy ostrovy</option>
						<option value="178">Španělsko</option>
						<option value="179">Švédsko</option>
						<option value="180">Švýcarsko</option>
						<option value="181">Tádžikistán</option>
						<option value="182">Tanzanie</option>
						<option value="183">Thajsko</option>
						<option value="184">Togo</option>
						<option value="185">Tonga</option>
						<option value="186">Trinidad a Tobago</option>
						<option value="187">Tunisko</option>
						<option value="188">Turecko</option>
						<option value="189">Turkmenistán</option>
						<option value="190">Tuvalu</option>
						<option value="191">Ukrajina</option>
						<option value="192">Uruguay</option>
						<option value="193">Uzbekistán</option>
						<option value="194">Vanuatu</option>
						<option value="195">Vatikán</option>
						<option value="196">Velká Británie</option>
						<option value="197">Venezuela</option>
						<option value="198">Vietnam</option>
						<option value="199">Východní Timor</option>
						<option value="200">Zambie</option>
						<option value="201">Zimbabwe</option>
					</select>
				</div>
				<small>Údaje s <span class="red">*</span> jsou povinné.</small>
				<input type="submit" value="Zaregistrovat">
			</form>
		</section>
		<section class="login">
			<form action="login/index.php" method="POST">
				<h2 class="page-title">Přihlášení</h2>
				<input type="hidden" name="action" value="login">
				<div class="labeled-input">
					<label for="email">Email:</label>
					<input type="text" name="email" class="input input-text">
				</div>
				<div class="labeled-input">
					<label for="password">Heslo:</label>
					<input type="password" name="password" class="input input-text">
				</div>
				<div class="blank-fill"></div>
				<input type="submit" value="Přihlásit">
			</form>
		</section>
	</main>
	<?php
		echo SIDEBAR_RIGHT;
		echo MAIN_CLOSE;
		echo FOOTER;
	?>
</body>
</html>