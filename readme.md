Geomatik Uygulamalar Poligon Hesabi Modül Uygulamasi
================

Bu depo Poligon Hesabi uygulamasinin acik kaynak kodlarini icermektedir. 
Aksi belirtilmedikce [application] klasoru altindaki tum kodlar Apache Licence, Version 2.0 lisansi ile sunulmaktadir.
(http://www.apache.org/licenses/LICENSE-2.0.html)

[application]: https://github.com/mtrcn/Poligon-Hesabi/tree/master/application

Kullanimi
-------

1) poligon_hesabi.sql dosyasini veritabani sunucunuzda(MySQL, PostgreSQL gibi) yeni bir veritabani olusturarak yukleyin.

2) [application/config/config.php][configphp] dosyasinda;
	
	$config['appID']
	$config['consumerKey']
	$config['consumerSecret']

degerleri Geomatik Uygulamalar [Gelistirici Hesabi][developer] içinde olusturdugunuz uygulamaniza ait degerler ile degistirin.

3) [application/config/database.php][databasephp] dosyasindeki veritabani parametrelerini kendi veritabani sunucunuza ait parametreler ile degistirin.

[configphp]: http://github.com/mtrcn/Poligon-Hesabi/blob/master/application/config/config.php
[databasephp]: http://github.com/mtrcn/Poligon-Hesabi/blob/master/application/config/database.php
[developer]: http://www.geomatikuygulamalar.com/v2/developer

Dokumantasyon
--------
[GUWiki] adresinde GUPA servisleri ve uygulama gelistirme konusunda daha fazla bilgi bulabilirsiniz.

[GUWiki]: http://www.geomatikuygulamalar.com/wiki


Bildirimler
--------

Lutfen tum hatalari ve sorularinizi [buradan][issues] paylasin.

[issues]: https://github.com/mtrcn/Poligon-Hesabi/issues