	if(document.getElementsByClassName('mapa')){//mediante el if llamamos la funcion cuando la requiramos
			var map = L.map('mapa').setView([41.734541, 1.830211], 19);

				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
				}).addTo(map);

				L.marker([41.734541, 1.830211]).addTo(map)
				.bindPopup('Consigue <br> las mejores semillas del mundo.')
				.openPopup();
		}