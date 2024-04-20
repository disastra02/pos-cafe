$(document).ready(function() 
{
    // Realtime dari dapur -> pelayan
    socketConnection.on('terimaPelayan', data => {
        let suara = new Audio(base_url + 'public/files/audio/success.wav');
        suara.play();
        show_toast(`Pesanan siap dikirim (Nama: ${data.customer_nama} | Pesanan: ${data.nama_barang})`);
    });

});