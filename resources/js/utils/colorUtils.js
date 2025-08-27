export function getColorFromIndicator(value, startHex, endHex) {
  if (value < 1) value = 1;
  if (value > 10) value = 10;

  startHex = startHex.replace(/^#/, '');
  if (startHex.length === 3) startHex = startHex.split('').map(c => c + c).join('');
  const startRgb = {
    r: parseInt(startHex.substring(0, 2), 16),
    g: parseInt(startHex.substring(2, 4), 16),
    b: parseInt(startHex.substring(4, 6), 16)
  };

  endHex = endHex.replace(/^#/, '');
  if (endHex.length === 3) endHex = endHex.split('').map(c => c + c).join('');
  const endRgb = {
    r: parseInt(endHex.substring(0, 2), 16),
    g: parseInt(endHex.substring(2, 4), 16),
    b: parseInt(endHex.substring(4, 6), 16)
  };

  const ratio = (value - 1) / 9;

  const r = Math.round(startRgb.r + ratio * (endRgb.r - startRgb.r));
  const g = Math.round(startRgb.g + ratio * (endRgb.g - startRgb.g));
  const b = Math.round(startRgb.b + ratio * (endRgb.b - startRgb.b));

  const toHex = c => {
    const hex = c.toString(16);
    return hex.length === 1 ? '0' + hex : hex;
  };

  return `#${toHex(r)}${toHex(g)}${toHex(b)}`;
}
