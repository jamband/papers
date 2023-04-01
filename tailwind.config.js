/** @type import("tailwindcss").Config */
export default {
  content: [
    "./resources/views/**/*.blade.php",
    "./storage/framework/views/*.php",
  ],
  future: {
    hoverOnlyWhenSupported: true,
  },
  theme: {
    container: {
      padding: "1rem",
    },
    screens: {
      md: "768px",
    },
    fontSize: {
      xs: ["0.8125rem", "1.25rem"],
      sm: ["0.9375rem", "1.5rem"],
      base: ["1.0625rem", "1.85rem"],
      "3xl": ["1.65rem", "2.5rem"],
      "4xl": ["2rem", "2.5rem"],
      "5xl": ["2.5rem", "2.5rem"],
    },
  },
};
