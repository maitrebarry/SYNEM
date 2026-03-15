const { chromium } = require('playwright');

(async () => {
  const baseUrl = 'http://127.0.0.1:8000';
  const creds = [
    { email: 'barrymoustapha908@gmail.com', password: 'admin123' },
    { email: 'hamarakida@gmail.com', password: '123456' },
  ];

  const browser = await chromium.launch({ headless: true });
  const page = await browser.newPage();

  async function tryLogin(email, password) {
    await page.goto(baseUrl + '/connexion', { waitUntil: 'domcontentloaded' });
    await page.fill('#email', email);
    await page.fill('#password', password);
    await Promise.all([
      page.waitForLoadState('networkidle'),
      page.click('button[type="submit"]'),
    ]);

    // Try opening target page explicitly after login postback.
    await page.goto(baseUrl + '/administration/pages/cartes-membres', { waitUntil: 'networkidle' });
    return !page.url().includes('/connexion');
  }

  let logged = false;
  for (const c of creds) {
    try {
      if (await tryLogin(c.email, c.password)) {
        logged = true;
        console.log('LOGIN_OK', c.email);
        break;
      }
    } catch (e) {
      // continue with next credentials
    }
  }

  if (!logged) {
    console.log('LOGIN_FAILED');
    await browser.close();
    process.exit(2);
  }

  const selector = 'input[name="militant_ids[]"]';
  await page.waitForTimeout(300);
  const total = await page.locator(selector).count();

  if (total === 0) {
    console.log('NO_CHECKBOXES');
    await browser.close();
    process.exit(3);
  }

  const checkedBefore = await page.locator(selector + ':checked').count();

  await page.click('#checkAllMilitants');
  await page.waitForTimeout(250);
  const checkedAfterCheckAll = await page.locator(selector + ':checked').count();

  await page.click('#uncheckAllMilitants');
  await page.waitForTimeout(250);
  const checkedAfterUncheckAll = await page.locator(selector + ':checked').count();

  // Signature canvas interaction test (mouse simulation)
  const canvas = page.locator('#signaturePad');
  const hasCanvas = await canvas.count();
  let signatureStatus = '';

  if (hasCanvas) {
    const box = await canvas.boundingBox();
    if (box) {
      const x = box.x + Math.min(40, Math.max(10, box.width * 0.2));
      const y = box.y + Math.min(40, Math.max(10, box.height * 0.3));
      await page.mouse.move(x, y);
      await page.mouse.down();
      await page.mouse.move(x + 40, y + 10);
      await page.mouse.up();
      await page.waitForTimeout(150);
      signatureStatus = (await page.locator('#signatureStatus').innerText()).trim();
    }
  }

  console.log(JSON.stringify({
    total,
    checkedBefore,
    checkedAfterCheckAll,
    checkedAfterUncheckAll,
    signatureStatus,
  }, null, 2));

  await browser.close();
})();
