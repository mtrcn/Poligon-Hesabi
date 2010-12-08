Geomatik Uygulamalar Poligon Hesabi Modül Uygulamasi
================

Bu depo Poligon Hesabi uygulamasinin acik kaynak kodlarini icermektedir. 
Aksi belirtilmedikce "application" klasoru altindaki tum kodlar Apache Licence, Version 2.0 lisansi ile sunulmaktadir.
(http://www.apache.org/licenses/LICENSE-2.0.html)


Kullanimi
----------

1) poligon_hesabi.sql dosyasini mySQL sunucunuzda yeni bir veritabani olusturarak yukleyin.

2) application/config/config.php dosyasindeki;
	
	$config['appID']
	$config['consumerKey']
	$config['consumerSecret']

parametreleri kendi uygulamanizinki ile degistirin.

3) application/config/database.php dosyasindeki veritabani parametrelerini kendi veritabani sunucunuza ait parametreler ile degistirin.


Dokumantasyon
--------
[GUWiki] adresinde GUPA servisleri ve uygulama gelistirme konusunda daha fazla bilgi bulabilirsiniz.

[GUWiki]: http://www.geomatikuygulamalar.com/wiki


Bildirimler
--------

Lutfen tum hatalari ve sorularinizi [buradan][issues] paylasin.

[issues]: https://github.com/mtrcn/Poligon-Hesabi/issues