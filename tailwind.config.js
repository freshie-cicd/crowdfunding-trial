/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/**/*.blade.php",
        "./resources/**/*.js",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
    ],
    theme: {
        extend: {
            backgroundImage: {
                "wave-pattern":
                    "url(data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwJSIgaGVpZ2h0PSI3M3B4IiB2aWV3Qm94PSIwIDAgMTI4MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGcgZmlsbD0iI2ZmZmZmZiI+PHBhdGggZD0iTTAgMHYxMDBjMjAgMTcuMyA0MCAyOS41MSA4MCAyOS41MSA1MS43OSAwIDc0LjY5LTQ4LjU3IDE1MS43NS00OC41NyA3My43MiAwIDkxIDU0Ljg4IDE5MS41NiA1NC44OEM1NDMuOTUgMTM1LjggNTU0IDE0IDY2NS42OSAxNGMxMDkuNDYgMCA5OC44NSA4NyAxODguMiA4NyA3MC4zNyAwIDY5LjgxLTMzLjczIDExNS42LTMzLjczIDU1Ljg1IDAgNjIgMzkuNjIgMTE1LjYgMzkuNjIgNTguMDggMCA1Ny41Mi00Ni41OSAxMTUtNDYuNTkgMzkuOCAwIDYwIDIyLjQ4IDc5Ljg5IDM5LjY5VjB6Ii8+PC9nPjwvc3ZnPg==)",
            },
        },
    },
    plugins: [],
};
