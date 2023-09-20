"use strict";

const Web3Modal = window.Web3Modal.default;
const WalletConnectProvider = window.WalletConnectProvider.default;
const Fortmatic = window.Fortmatic;
const Torus = window.Torus;
const Portis = window.Portis;
//const WalletLink = window.WalletLink_2;

// Web3modal instance
let web3Modal

// Chosen wallet provider given by the dialog window
let provider;

// Address of the selected account
let selectedAccount;

// Web3Loaded
let web3ModalProv;

function web3ModalInit() {
  // Tell Web3modal what providers we have available.
  // Built-in web browser provider (only one can exist as a time)
  // like MetaMask, Brave or Opera is added automatically by Web3modal
  const customNetworkOptions = {
    rpcUrl: fortmatic_rpcurl_0,
    chainId: fortmatic_chainid_1
}

  const providerOptions = {
    walletconnect: {
      package: WalletConnectProvider,
      options: {
        // Mikko's test key - don't copy as your mileage may vary
        infuraId: wallet_connect_infuraid_3,
      }
    },
    fortmatic: {
      package: Fortmatic, // required
      options: {
        key: fortmatic_key_2, // required,
        network: customNetworkOptions // if we don't pass it, it will default to localhost:8454
      }
    },
    binancechainwallet: {
      package: true
    },
    walletlink: {
      package: false,
      options: {
        appName: "My Awesome App", // Required
        infuraId: "8043bb2cf99347b1bfadfb233c5325c0", // Required unless you provide a JSON RPC url; see `rpc` below
        rpc: "", // Optional if `infuraId` is provided; otherwise it's required
        chainId: 1, // Optional. It defaults to 1 if not provided
        appLogoUrl: null, // Optional. Application logo image URL. favicon is used if unspecified
        darkMode: false // Optional. Use dark theme, defaults to false
      }
    },
    torus: {
      package: Torus, // required
    },
    portis: {
      package: Portis, // required
      options: {
        id: portis_id_4 // required
      }
    }
  
  
    
  };

  web3Modal = new Web3Modal({
    cacheProvider: false, // optional
    providerOptions, // required
    disableInjectedProvider: false, // optional. For MetaMask / Brave / Opera.
  });
}

async function fetchAccountData() {
 
  web3ModalProv = new Web3(provider);
 
  // Subscribe to accounts change
  provider.on("accountsChanged", (accounts) => {
    console.log(accounts);
  });

  // Subscribe to chainId change
  provider.on("chainChanged", (chainId) => {
    console.log(chainId);
  });

  // Subscribe to session disconnection
  provider.on("disconnect", (code, reason) => {
    console.log(code, reason);
  });
}

async function refreshAccountData() {
  await fetchAccountData(provider);
}

async function onConnectLoadWeb3Modal() {
  try {
    //provider = await web3Modal.connect();
    provider = await web3Modal.connect('binancechainwallet');
  } catch(e) {
    console.log("Could not get a wallet connection", e);
    return;
  }

  await refreshAccountData();
}

window.addEventListener('load', async () => {
  web3ModalInit();
});
