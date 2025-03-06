<script setup lang="ts">

const props = defineProps<{
    code?: string;
}>();
</script>

<template>
    <span v-if="props.code === 'XAU'">Gramul de aur</span>
    <span v-if="props.code === 'XDR'">Unitate de fond (FMI)</span>
    <span v-if="props.code === 'GBP'">Lira sterlină</span>
    <span v-if="props.code === 'CHF'">Francul elveţian</span>
    <span v-if="props.code === 'EUR'">Euro</span>
    <span v-if="props.code === 'USD'">Dolarul SUA</span>
    <span v-if="props.code === 'SGD'">Dolarul singaporez</span>
    <span v-if="props.code === 'ISK'">100 Coroane islandeze</span>
    <span v-if="props.code === 'CAD'">Dolarul canadian</span>
    <span v-if="props.code === 'JPY'">100 Yeni japonezi</span>
    <span v-if="props.code === '100 Yeni japonezi'"></span>
    <span v-if="props.code === 'AUD'">Dolarul australian</span>
    <span v-if="props.code === 'NZD'">Dolarul neo-zeelandez</span>
    <span v-if="props.code === 'BGN'">Leva bulgarească</span>
    <span v-if="props.code === 'ILS'">Shekelul israelian</span>
    <span v-if="props.code === 'AED'">Dirhamul Emiratelor Arabe</span>
    <span v-if="props.code === 'HUF'">100 Forinți maghiari</span>
    <span v-if="props.code === 'PLN'">Zlotul polonez</span>
    <span v-if="props.code === 'MYR'">Ringgitul malaysian</span>
    <span v-if="props.code === 'BRL'">Realul brazilian</span>
    <span v-if="props.code === 'DKK'">Coroana daneză</span>
    <span v-if="props.code === 'HRK'">Coroana croată</span>
    <span v-if="props.code === 'CNY'">Renminbi-ul chinezesc (RMB)</span>
    <span v-if="props.code === 'HKD'">Dolarul din Hong Kong</span>
    <span v-if="props.code === 'SEK'">Coroana suedeză</span>
    <span v-if="props.code === 'NOK'">Coroana norvegiană</span>
    <span v-if="props.code === 'KRW'">100 Woni sud-coreeni</span>
    <span v-if="props.code === 'MDL'">Leul moldovenesc</span>
    <span v-if="props.code === 'ZAR'">Randul sud-african</span>
    <span v-if="props.code === 'MXN'">Peso-ul mexican</span>
    <span v-if="props.code === 'CZK'">Coroana cehă</span>
    <span v-if="props.code === 'THB'">Bahtul thailandez</span>
    <span v-if="props.code === 'TRY'">Noua lira turcească</span>
    <span v-if="props.code === 'UAH'">Hryvna ucraineană</span>
    <span v-if="props.code === 'EGP'">Lira egipteană</span>
    <span v-if="props.code === 'PHP'">Pesoul filipinez</span>
    <span v-if="props.code === 'INR'">Rupia indiană</span>
    <span v-if="props.code === 'RUB'">Rubla rusească</span>
    <span v-if="props.code === 'RSD'">Dinarul sârbesc</span>
    <span v-if="props.code === 'IDR'">100 Rupii indoneziene</span>
</template>
