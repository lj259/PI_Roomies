module.exports = function(api) {
  api.cache(true);
  return {
    presets: ['babel-preset-expo'], // Usa el preset oficial de Expo
    plugins: ['react-native-reanimated/plugin'], // Plugin necesario para reanimated
  };
};
