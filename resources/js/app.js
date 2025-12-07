import './bootstrap';
import Chart from 'chart.js/auto';
window.Chart = Chart;


import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

if (window.Echo) {
    // Stocks
    window.Echo.channel('stocks')
        .listen('StockUpdated', (e) => {
            console.log('Stock updated', e);
            // Exemple : afficher une notification, mettre à jour un widget...
        });

    // Activité (canal privé - super-admin uniquement)
    window.Echo.private('activity')
        .listen('ActivityLoggedEvent', (e) => {
            console.log('Activity log', e);
            // On peut utiliser openSmartModal(...) pour prévenir le Super Admin en live.
        });
}

if (window.Echo) {
    // Ventes (canal privé - gerant/super-admin uniquement)
    window.Echo.private('sales')
        .listen('SaleCreatedEvent', (e) => {

            // Notifier l'utilisateur
            if (typeof openSmartModal === 'function') {
                openSmartModal(
                    "Nouvelle vente",
                    `${e.seller} a enregistré une facture de ${e.amount} FCFA`
                );
            }

            // Rafraîchir les widgets auto-refresh
            const components = document.querySelectorAll("[data-autorefresh='true']");
            components.forEach(async (el) => {
                const url = el.dataset.url;
                if (!url) return;
                const html = await fetch(url).then(r => r.text());
                el.innerHTML = html;
            });
        });
}
