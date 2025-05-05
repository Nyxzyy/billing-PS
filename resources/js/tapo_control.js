// scripts/control-plug.js
const fs = require('fs');
const path = require('path');
const { cloudLogin, loginDeviceByIp } = require('tp-link-tapo-connect');

const EMAIL    = 'theodorusvalenzio@gmail.com';
const PASSWORD = 'J3susInsid3!';
const CACHE    = path.resolve(__dirname, '.tapo-cache.json');
const MAX_RETRIES = 3;
const BACKOFF_MS  = 2000;

/**
 * Simpan cache (misal cookie/token) ke file
 */
async function saveCache(data) {
  fs.writeFileSync(CACHE, JSON.stringify(data), { mode: 0o600 });
}

/**
 * Baca cache kalau ada
 */
function loadCache() {
  if (!fs.existsSync(CACHE)) return null;
  try {
    return JSON.parse(fs.readFileSync(CACHE));
  } catch {
    return null;
  }
}

async function getCloudApi() {
  // Coba pakai cache
  const cached = loadCache();
  if (cached && cached.cookie) {
    try {
      // cloudLogin menerima opsi cookie dari cache
      return await cloudLogin(EMAIL, PASSWORD, { cookie: cached.cookie });
    } catch {
      // gagal pakai cache, lakukan login ulang di bawah
    }
  }

  // Login baru dan simpan cookie
  const api = await cloudLogin(EMAIL, PASSWORD);
  await saveCache({ cookie: api.getCookie() });
  return api;
}

async function controlPlug(action, ip) {
  let cloudApi;
  try {
    cloudApi = await getCloudApi();
  } catch (e) {
    console.warn('⚠️ Gagal login cloud, fallback ke local only');
  }

  // Jika ada cloudApi, bisa gunakan listDevicesByType dsb.
  // Tapi untuk kontrol lokal cukup loginDeviceByIp
  for (let attempt = 1; attempt <= MAX_RETRIES; attempt++) {
    try {
      // Cloud handshake (jika berhasil), atau langsung local
      if (cloudApi) await cloudApi.listDevicesByType('SMART.TAPOPLUG');

      const plug = await loginDeviceByIp(EMAIL, PASSWORD, ip);
      if (action === 'on')      await plug.turnOn();
      else if (action === 'off') await plug.turnOff();
      else throw new Error(`Unknown action "${action}"`);

      console.log(`✅ Plug ${action} berhasil`);
      return;
    } catch (e) {
      const msg = String(e.message || e);
      if (msg.includes('rate limit') && attempt < MAX_RETRIES) {
        console.warn(`⚠️ Rate limit detected, retry ${attempt}/${MAX_RETRIES} after ${BACKOFF_MS}ms…`);
        await new Promise(r => setTimeout(r, BACKOFF_MS));
        continue;
      }
      // jika bukan rate-limit atau sudah habis retry:
      throw e;
    }
  }
}

(async () => {
  const [,, action, ip] = process.argv;
  if (!action || !ip) {
    console.error('Usage: node control-plug.js <on|off> <ip>');
    process.exit(1);
  }
  try {
    await controlPlug(action, ip);
  } catch (e) {
    console.error('❌ ERROR:', e.message);
    process.exit(1);
  }
})();
