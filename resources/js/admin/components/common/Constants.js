export default {
    VERSION: 0.5,
    API_URL: '/api/v1/',

    map: {
        instance: null,
        apiKey: 'ba831be8-8f92-4ff7-9ea2-9b7e919e2231',
        lang: 'ru_RU',
        coordorder: 'latlong',
        version: '2.1',
        currentCoords: '',
        mode: 'debug',

        defaultCoords: "53.893009,27.567444",
        lastCoords: "53.893009,27.567444",
        scrollZoom: false,
        options: {
            layout: "default#image",
            imageSize: [30, 40],
            contentOffset: [0, 0]
        },
        coords: [0, 0],
        center: [0, 0],
        controls: ["smallMapDefaultSet", ""],
        selectedSurfaces: "",
        surfaces: [
            {
                id: "1",
                city: "Moscow",
                type: "Mediawall",
                address: 'ТРЦ "Океания", пр. Кутузовский, 57',
                coords: "55.727790, 37.475986"
            },
            {
                id: "2",
                city: "Moscow",
                type: "Mediawall",
                address: 'ТРЦ "Хорошо!", Хорошёвское шоссе, 27',
                coords: "55.777138, 37.523430"
            },
        ],
        place: []
    },

    editor: {
        config: {},
    }
};

