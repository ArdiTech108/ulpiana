<?php
require_once 'api.php';

$teachers = [
    ['Hysri Rrahmani', 'hysri.rrahmani@ulpiana.edu', 'Gjuhë Shqipe'],
    ['Sebahate Gashi', 'sebahate.gashi@ulpiana.edu', 'Gjuhë Shqipe'],
    ['Sebahate Lekaj', 'sebahate.lekaj@ulpiana.edu', 'Gjuhë Shqipe'],
    ['Shqipe Jashanica', 'shqipe.jashanica@ulpiana.edu', 'Gjuhë Shqipe'],
    ['Ylber Shala', 'ylber.shala@ulpiana.edu', 'Gjuhë Shqipe'],
    ['Arlinda Ademi', 'arlinda.ademi@ulpiana.edu', 'Gjuhë Shqipe'],
    ['Luljeta Retkoceri', 'luljeta.retkoceri@ulpiana.edu', 'Gjuhë Shqipe'],
    ['Albana Haliti', 'albana.haliti@ulpiana.edu', 'Gjuhë Shqipe'],
    ['Ylber Dedushi', 'ylber.dedushi@ulpiana.edu', 'Gjuhë Angleze'],
    ['Besa Tmava', 'besa.tmava@ulpiana.edu', 'Gjuhë Angleze'],
    ['Fitim Mustafa', 'fitim.mustafa@ulpiana.edu', 'Gjuhë Angleze'],
    ['Albulena Kelmendi', 'albulena.kelmendi@ulpiana.edu', 'Gjuhë Angleze'],
    ['Blerina Salihu', 'blerina.salihu@ulpiana.edu', 'Gjuhë Angleze'],
    ['Flakresa Jashari', 'flakresa.jashari@ulpiana.edu', 'Gjuhë Angleze'],
    ['Arben Lekaj', 'arben.lekaj@ulpiana.edu', 'Gjuhë e dytë e huaj'],
    ['Gjejlane Shashivari', 'gjyljane.shashivari@ulpiana.edu', 'Gjuhë e dytë e huaj'],
    ['Sevdaim Tasholli', 'sevdaim.tasholli@ulpiana.edu', 'Gjuhë e dytë e huaj'],
    ['Minire Bytyqi', 'minire.bytyqi@ulpiana.edu', 'Gjuhë e dytë e huaj'],
    ['Zyrafete Murseli', 'zyrafete.murseli@ulpiana.edu', 'Matematikë'],
    ['Xhejlane Fetahu', 'xhejlane.fetahu@ulpiana.edu', 'Matematikë'],
    ['Lendita Demiri', 'lendita.demiri@ulpiana.edu', 'Matematikë'],
    ['Shqipe Salihu', 'shqipe.salihu@ulpiana.edu', 'Matematikë'],
    ['Arbnora Retkoceri', 'arbnora.retkoceri@ulpiana.edu', 'Matematikë'],
    ['Albulena Bytyqi', 'albulena.bytyqi@ulpiana.edu', 'Matematikë'],
    ['Izjadin Qeriqi', 'izjadin.qeriqi@ulpiana.edu', 'Matematikë'],
    ['Edi Reqica', 'edi.reqica@ulpiana.edu', 'Matematikë'],
    ['Ramadan Berisha', 'ramadan.berisha@ulpiana.edu', 'Biologji'],
    ['Blerina Gërxhaliu', 'blerina.gerxhaliu@ulpiana.edu', 'Biologji'],
    ['Xhemile Shabiu', 'xhemile.shabiu@ulpiana.edu', 'Biologji'],
    ['Sabrie Asllani', 'sabrie.asllani@ulpiana.edu', 'Biologji'],
    ['Arben Spahiu', 'arben.spahiu@ulpiana.edu', 'Fizikë'],
    ['Qamile Xheladini', 'qamile.xheladini@ulpiana.edu', 'Fizikë'],
    ['Valbona Kryeziu', 'valbona.kryeziu@ulpiana.edu', 'Fizikë'],
    ['Lirim Dragaqina', 'lirim.dragaqina@ulpiana.edu', 'Fizikë'],
    ['Fatime Limani', 'fatime.limani@ulpiana.edu', 'Fizikë'],
    ['Nerxhivane Tasholli', 'nexhmije.tasholli@ulpiana.edu', 'Kimi'],
    ['Ilir Kolshi', 'ilir.kolshi@ulpiana.edu', 'Kimi'],
    ['Lendita Pirraku', 'lendita.pirraku@ulpiana.edu', 'Kimi'],
    ['Sebahate Konjufca', 'sebahate.konjufca@ulpiana.edu', 'Kimi'],
    ['Naser Kaqara', 'naser.kaqara@ulpiana.edu', 'Gjeografi'],
    ['Alban Aliu', 'alban.aliu@ulpiana.edu', 'Gjeografi'],
    ['Arben Hasani', 'arben.hasani@ulpiana.edu', 'Gjeografi'],
    ['Xhevrije Shabani', 'xhevrije.shabani@ulpiana.edu', 'Gjeografi'],
    ['Ismet Jetullahu', 'ismet.jetullahu@ulpiana.edu', 'Gjeografi'],
    ['Liridona Rashiti', 'liridona.rashiti@ulpiana.edu', 'Gjeografi'],
    ['Qendrim Ibrahimi', 'qendrim.ibrahimi@ulpiana.edu', 'Histori - Ed. Qytetare'],
    ['Aida Gashi', 'aida.gashi@ulpiana.edu', 'Histori - Ed. Qytetare'],
    ['Emine Dedushi', 'emine.dedushi@ulpiana.edu', 'Histori - Ed. Qytetare'],
    ['Liridon Agushi', 'liridon.agushi@ulpiana.edu', 'Histori - Ed. Qytetare'],
    ['Enis Shala', 'enis.shala@ulpiana.edu', 'Histori - Ed. Qytetare'],
    ['Jehona Luma', 'jehona.luma@ulpiana.edu', 'Histori - Ed. Qytetare'],
    ['Feride Thaqi', 'feride.thaqi@ulpiana.edu', 'Histori - Ed. Qytetare'],
    ['Rineta Durmishi', 'rineta.durmishi@ulpiana.edu', 'Histori - Ed. Qytetare'],
    ['Pranvera Ilazi', 'pranvera.ilazi@ulpiana.edu', 'Psikologji'],
    ['Shpetim Azemi', 'shpetim.azemi@ulpiana.edu', 'Psikologji'],
    ['Fatmir Grajqevci', 'fatmir.grajqevci@ulpiana.edu', 'Filozofi - Sociologji'],
    ['Elmi Dragusha', 'elmi.dragusha@ulpiana.edu', 'Filozofi - Sociologji'],
    ['Xhejlane Bytyqi', 'xhejlane.bytyqi@ulpiana.edu', 'Filozofi - Sociologji'],
    ['Alban Zeqiri', 'alban.zeqiri@ulpiana.edu', 'T.I.K'],
    ['Naime Krasniqi', 'naime.krasniqi@ulpiana.edu', 'T.I.K'],
    ['Ekrem Salihu', 'ekrem.salihu@ulpiana.edu', 'T.I.K'],
    ['Leutrim Luma', 'leutrim.luma@ulpiana.edu', 'T.I.K'],
    ['Armend Rexhepi', 'armend.rexhepi@ulpiana.edu', 'Art Muzikor-Figurativ'],
    ['Hysen Bytyqi', 'hysen.bytyqi@ulpiana.edu', 'Art Muzikor-Figurativ'],
    ['Nexhmije Mustafa', 'nexhmije.mustafa@ulpiana.edu', 'Art Muzikor-Figurativ'],
    ['Behar Sylejmani', 'behar.sylejmani@ulpiana.edu', 'Art Muzikor-Figurativ'],
    ['Milazim Sadiku', 'milazim.sadiku@ulpiana.edu', 'Edukatë Fizike'],
    ['Naser Magashi', 'naser.magashi@ulpiana.edu', 'Edukatë Fizike'],
    ['Fidan Tmava', 'fidan.tmava@ulpiana.edu', 'Edukatë Fizike'],
    ['Valon Sylejmani', 'valon.sylejmani@ulpiana.edu', 'Edukatë Fizike'],
    ['Filloreta Azemi', 'filloreta.azemi@ulpiana.edu', 'Edukatë Fizike'],
    ['Adil Hashani', 'adil.hashani@ulpiana.edu', 'Edukatë Fizike'],
    ['Minife Sukaj', 'minife.sukaj@ulpiana.edu', 'Edukatë Fizike'],
    ['Albiona Bahtiri', 'albiona.bahtiri@ulpiana.edu', 'Edukatë Fizike'],
    ['Nurije Shala', 'nurije.shala@ulpiana.edu', 'Mësim Zgjedhor'],
    ['Arben Tasholli', 'arben.tasholli@ulpiana.edu', 'Mësim Zgjedhor'],
    ['Emine Konxheli', 'emine.konxheli@ulpiana.edu', 'Mësim Zgjedhor'],
    ['Muhamet Kozhani', 'muhamet.kozhani@ulpiana.edu', 'Mësim Zgjedhor'],
    ['Betim Krasniqi', 'betim.krasniqi@ulpiana.edu', 'Mësim Zgjedhor'],
    ['Ramadan Bajraktari', 'ramadan.bajraktari@ulpiana.edu', 'Mësim Zgjedhor']
];

echo "<h2>Duke regjistruar profesorët...</h2>";
$count = 0;
$password = password_hash('ulpiana2024', PASSWORD_DEFAULT);

foreach ($teachers as $t) {
    $name = $t[0];
    $email = $t[1];
    $subject = $t[2] ?? null;
    
    // Kontrollo nëse ekziston
    $check = db()->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    if ($check->fetch()) {
        echo "Anashkaluar: $name ($email) - Ekziston.<br>";
        continue;
    }
    
    // Shtoje
    $ins = db()->prepare("INSERT INTO users (full_name, email, password_hash, role, teacher_subject) VALUES (?, ?, ?, 'teacher', ?)");
    if ($ins->execute([$name, $email, $password, $subject])) {
        $count++;
    }
}

echo "Përfundoi! U shtuan $count profesorë të rinj.";
