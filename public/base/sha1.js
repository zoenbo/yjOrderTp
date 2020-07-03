/*
A JavaScript implementation of the Secure Hash Algorithm,SHA-1,as defined
in FIPS PUB 180-1
Version 2.1a Copyright Paul Johnston 2000 - 2002.
Other contributors: Greg Holt,Andrew Kepert,Ydnar,Lostinet
Distributed under the BSD License
See http://pajhome.org.uk/crypt/md5 for details.
*/

function sha1 (s) {
  return binb2hex(coreSha1(str2binb(s), s.length * 8));
}

function coreSha1 (x, len) {
  x[len >> 5] |= 0x80 << (24 - len % 32); x[((len + 64 >> 9) << 4) + 15] = len;
  let w = [80];
  let a = 1732584193;
  let b = -271733879;
  let c = -1732584194;
  let d = 271733878;
  let e = -1009589776;
  for (let i = 0; i < x.length; i += 16) {
    let oldA = a;
    let oldB = b;
    let oldC = c;
    let oldD = d;
    let oldE = e;
    for (let j = 0; j < 80; j++) {
      w[j] = j < 16 ? x[i + j] : rol(w[j - 3] ^ w[j - 8] ^ w[j - 14] ^ w[j - 16], 1);
      let t = safeAdd(safeAdd(rol(a, 5), sha1Ft(j, b, c, d)), safeAdd(safeAdd(e, w[j]), sha1Kt(j)));
      e = d;
      d = c;
      c = rol(b, 30);
      b = a;
      a = t;
    }
    a = safeAdd(a, oldA);
    b = safeAdd(b, oldB);
    c = safeAdd(c, oldC);
    d = safeAdd(d, oldD);
    e = safeAdd(e, oldE);
  }
  return [a, b, c, d, e];
}

function sha1Ft (t, b, c, d) {
  if (t < 20) return (b & c) | ((~b) & d);
  if (t < 40) return b ^ c ^ d;
  if (t < 60) return (b & c) | (b & d) | (c & d);
  return b ^ c ^ d;
}

function sha1Kt (t) {
  return (t < 20) ? 1518500249 : (t < 40) ? 1859775393 : (t < 60) ? -1894007588 : -899497514;
}

function safeAdd (x, y) {
  let lsw = (x & 0xFFFF) + (y & 0xFFFF);
  let msw = (x >> 16) + (y >> 16) + (lsw >> 16);
  return (msw << 16) | (lsw & 0xFFFF);
}

function rol (num, cnt) {
  return (num << cnt) | (num >>> (32 - cnt));
}

function str2binb (str) {
  let bin = [];
  let mask = (1 << 8) - 1;
  for (let i = 0; i < str.length * 8; i += 8) {
    bin[i >> 5] |= (str.charCodeAt(i / 8) & mask) << (32 - 8 - i % 32);
  }
  return bin;
}

function binb2hex (binArray) {
  let hexTab = '0123456789abcdef';
  let str = '';
  for (let i = 0; i < binArray.length * 4; i++) {
    str += hexTab.charAt((binArray[i >> 2] >> ((3 - i % 4) * 8 + 4)) & 0xF) + hexTab.charAt((binArray[i >> 2] >> ((3 - i % 4) * 8)) & 0xF);
  }
  return str;
}
