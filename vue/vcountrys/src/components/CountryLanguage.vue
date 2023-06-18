<template>
  <div style="float:left;" class="countrylanguages container">
    <Alert v-if="alert" v-bind:message="alert" />
    <h1 class="page-header">Manage Countrylanguages</h1>
    <div>
      <button @click="handleJsonButtonClick" v-show="!jsonButtonHidden">JSON</button>
      <button @click="handleXmlButtonClick" v-show="!xmlButtonHidden">XML</button>
    </div>
    <input class="form-control" placeholder="Enter Countrycode" v-model="filterInput">
    <br />
    <table v-if="filteredCountryLanguages.length > 0" class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>CountryCode</th>
          <th>Language</th>
          <th>IsOfficial</th>
          <th>Percentage</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="countrylanguage in filteredCountryLanguages" :key="countrylanguage.ID">
          <td>{{ countrylanguage.ID }}</td>
          <td>{{ countrylanguage.CountryCode }}</td>
          <td>{{ countrylanguage.Language }}</td>
          <td>{{ countrylanguage.IsOfficial }}</td>
          <td>{{ countrylanguage.Percentage }}</td>
          <td><router-link class="btn btn-default" v-bind:to="'/countrylanguage/'+countrylanguage.ID">View</router-link></td>
        </tr>
      </tbody>
    </table>
    <p v-else>No data available.</p>
  </div>
</template>

<script>
import Alert from './Alert';

export default {
  name: 'countrylanguages',
  data() {
    return {
      countryLanguages: [],
      alert: '',
      filterInput: '',
      jsonButtonHidden: false,
      xmlButtonHidden: false,
    };
  },
  methods: {
    handleJsonButtonClick() {
      console.log('JSON button clicked');
      this.fetchData('application/json');
      this.jsonButtonHidden = true;
      this.xmlButtonHidden = true;
    },
    handleXmlButtonClick() {
      console.log('XML button clicked');
      this.fetchData('application/xml');
      this.jsonButtonHidden = true;
      this.xmlButtonHidden = true;
    },
    fetchData(acceptHeader) {
      const url = 'http://localhost/dataprocessing/public/api/countrylanguage';
      fetch(url, {
        headers: {
          Accept: acceptHeader,
        },
      })
        .then(response => {
          if (acceptHeader === 'application/json') {
            return response.json();
          } else if (acceptHeader === 'application/xml') {
            return response.text();
          } else {
            throw new Error('Invalid accept header');
          }
        })
        .then(data => {
          if (acceptHeader === 'application/json') {
            console.log('Received JSON data:', data);
            this.countryLanguages = data;
          } else if (acceptHeader === 'application/xml') {
            console.log('Received XML data:', data);
            const parser = new DOMParser();
            const xmlDoc = parser.parseFromString(data, 'text/xml');
            const countryLanguageNodes = xmlDoc.querySelectorAll('countrylanguage');
            const countryLanguages = Array.from(countryLanguageNodes).map(countryLanguage => {
              return {
                ID: countryLanguage.querySelector('ID').textContent,
                CountryCode: countryLanguage.querySelector('CountryCode').textContent,
                Language: countryLanguage.querySelector('Language').textContent,
                IsOfficial: countryLanguage.querySelector('IsOfficial').textContent,
                Percentage: countryLanguage.querySelector('Percentage').textContent,
              };
            });
            this.countryLanguages = countryLanguages;
          }
        })
        .catch(error => {
          console.error('Error occurred:', error);
        });
    },
    filterBy(list, value) {
      value = value.toUpperCase();
      return list.filter(countryLanguage => {
        return countryLanguage.CountryCode.indexOf(value) > -1;
      });
    },
  },
  created() {
    if (this.$route.query.alert) {
      this.alert = this.$route.query.alert;
    }
  },
  components: {
    Alert,
  },
  computed: {
    filteredCountryLanguages() {
      return this.filterBy(this.countryLanguages, this.filterInput);
    },
  },
};
</script>

<style scoped>
/* CSS styles */
</style>
