jQuery(document).ready(function ($) {
    const server = "wss://api.ecmarkets.co/mt4/ws/quote";
    let ws;

    function startWebSocket(market) {
        ws = new WebSocket(server, "WEB_CLIENT");
        let previousPrices = {};

        ws.onopen = () => {
            switch (market) {
                case 'popular':
                    ws.send("-2");
                    break;
                case 'forex':
                    ws.send("1");
                    break;
                case 'metals':
                    ws.send("2");
                    break;
                case 'energy':
                    ws.send("3");
                    break;
                case 'indices':
                    ws.send("4");
                    break;
                case 'cryptos':
                    ws.send("5");
                    break;
            }
        };

        ws.onmessage = (event) => {
            const jsonArray = JSON.parse(event.data);

            jsonArray.forEach(item => {
                let symbol = item.symbol;
                let oldBid = previousPrices[symbol] ? previousPrices[symbol].bid : null;
                let oldAsk = previousPrices[symbol] ? previousPrices[symbol].ask : null;
                let newBid = item.bid;
                let newAsk = item.ask;

                updatePrices(symbol, oldBid, newBid, oldAsk, newAsk);
                previousPrices[symbol] = { ask: newAsk, bid: newBid };
            });
        };

        ws.onclose = function () {};

        ws.onerror = function (error) {};
    }

    startWebSocket('popular');

    function closeWebSocket() {
        if (ws) {
            ws.close();
            ws = null;
        }
    }

    $('#live-prices-tabs .nav-link').on('click', function () {
        let market = $(this).data('id');
        closeWebSocket();
        startWebSocket(market);
        $('#live-prices-tabs-content .table-container').html('');
        $('.loading-container').show();

        $.ajax({
            type: 'POST',
            url: livePricesObj.rest_url,
            beforeSend: function (xhr) {
                xhr.setRequestHeader('X-WP-Nonce', livePricesObj.nonce);
            },
            data: { 'market': market },
            success: function (response) {
                if (response) {
                    $(`#live-prices-tabs-content #${market} .table-container`).html(response);
                    $('.loading-container').hide();
                }
            },
            error: function () {}
        });
    });

    function updatePrices(symbol, oldBid, newBid, oldAsk, newAsk) {
        $('.live-prices-table .symbol').each(function (index, value) {
            if ($(value).text() === symbol) {
                setBidAsk(oldBid, newBid, index, '.live-prices-table .bid');
                setBidAsk(oldAsk, newAsk, index, '.live-prices-table .ask');

                let point = $('.live-prices-table .spread').eq(index).data('point');
                let spread = calculateSpread(newBid, newAsk, point);
                $('.live-prices-table .spread').eq(index).text(spread);

                let closingPrice = $('.live-prices-table .change').eq(index).data('closing_price');
                let change = calculateChange(newBid, closingPrice, index);
                $('.live-prices-table .change').eq(index).text(change + '%');
            }
        });

        $('.default-symbols-container .symbol').each(function (index, value) {
            if ($(value).text() === symbol) {
                setBidAsk(oldBid, newBid, index, '.default-symbols-container .bid');
                setBidAsk(oldAsk, newAsk, index, '.default-symbols-container .ask');
            }
        });
    }

    function setBidAsk(oldVal, newVal, index, identifier) {
        $(identifier).eq(index).text(newVal);

        if (oldVal !== null) {
            if (newVal > oldVal) {
                $(identifier).eq(index).removeClass('priceRed').addClass('priceGreen');
            } else if (newVal < oldVal) {
                $(identifier).eq(index).removeClass('priceGreen').addClass('priceRed');
            }
        }
    }

    function calculateSpread(bid,ask,point) {
        let spread = bid - ask;
        let convertedNum = (spread / point) / 10;
        return convertedNum.toFixed(1);
    }

    function calculateChange(bid, closingPrice, index) {
        let change = (bid - closingPrice) / closingPrice * 100;
        change = change.toFixed(2);

        if (change > 0) {
            $('.live-prices-table .change').eq(index).removeClass('priceRed').addClass('priceGreen');
        } else if (change < 0) {
            $('.live-prices-table .change').eq(index).removeClass('priceGreen').addClass('priceRed');
        }
        return change;
    }

    $(window).on('beforeunload', function () {
        closeWebSocket();
    });
});
