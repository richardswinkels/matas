export const formatEuro = {
    methods: {
        formatEuro(amount) {
            const parsedAmount = parseFloat(amount);
            const formattedAmount = parsedAmount.toFixed(2).replace('.', ','); // Replace decimal point with comma
            return `€ ${formattedAmount}`;
        }
    }
};

export const isAdmin = {
    computed: {
        isAdmin() {
            return localStorage.getItem('isAdmin') === 'true';
        }
    }
};

export const isLoggedIn = {
    computed: {
        isLoggedIn() {
            return localStorage.getItem('loggedIn') === 'true';
        }
    }
};
