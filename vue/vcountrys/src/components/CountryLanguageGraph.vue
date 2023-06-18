<template>
    <div>
      <h1>Country Languages</h1>
      <div>
        <button @click="handleJsonButtonClick" v-show="!jsonButtonHidden">JSON</button>
        <button @click="handleXmlButtonClick" v-show="!xmlButtonHidden">XML</button>
      </div>
      <svg ref="chart" v-if="showChart"></svg>
    </div>
  </template>
  
  <script>
  import * as d3 from 'd3';
  
  export default {
    name: 'country-languages',
    data() {
      return {
        languages: [],
        colors: d3.scaleOrdinal(d3.schemeCategory10),
        jsonButtonHidden: false,
        xmlButtonHidden: false,
        showChart: false,
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
          .then((response) => {
            if (acceptHeader === 'application/json') {
              return response.json();
            } else if (acceptHeader === 'application/xml') {
              return response.text();
            } else {
              throw new Error('Invalid accept header');
            }
          })
          .then((data) => {
            if (acceptHeader === 'application/json') {
              console.log('Received JSON data:', data);
              this.languages = data.filter((language) => language.CountryCode === 'NLD');
            } else if (acceptHeader === 'application/xml') {
              console.log('Received XML data:', data);
              const parser = new DOMParser();
              const xmlDoc = parser.parseFromString(data, 'text/xml');
              const languages = Array.from(xmlDoc.getElementsByTagName('countrylanguage')).map((language) => {
                const nameElement = language.querySelector('Language');
                const countryCodeElement = language.querySelector('CountryCode');
                const percentageElement = language.querySelector('Percentage');
                const name = nameElement ? nameElement.textContent : '';
                const countryCode = countryCodeElement ? countryCodeElement.textContent : '';
                const percentage = percentageElement ? parseFloat(percentageElement.textContent) : 0;
                return { Language: name, CountryCode: countryCode, Percentage: percentage };
              });
              this.languages = languages.filter((language) => language.CountryCode === 'COM');
            }
  
            this.showChart = true;
            this.$nextTick(() => {
              this.drawChart();
            });
          })
          .catch((error) => {
            console.error('Error occurred:', error);
          });
      },
      drawChart() {
        const width = 1000;
        const height = 600;
        const radius = Math.min(width, height) / 2;
  
        const svg = d3
          .select(this.$refs.chart)
          .attr('width', width)
          .attr('height', height)
          .append('g')
          .attr('transform', 'translate(' + width / 2 + ',' + height / 2 + ')');
  
        const pie = d3.pie().value((d) => d.Percentage).sort(null);
  
        const arc = d3.arc().innerRadius(0).outerRadius(radius);
  
        const arcs = svg
          .selectAll('arc')
          .data(pie(this.languages))
          .enter()
          .append('g')
          .attr('class', 'arc');
  
        arcs
          .append('path')
          .attr('d', arc)
          .attr('fill', (d, i) => this.colors(i));
  
        const legend = d3
          .select(this.$refs.chart)
          .append('g')
          .attr('class', 'legend')
          .attr('transform', 'translate(' + (width - 200) + ',20)');
  
        const legendItem = legend
          .selectAll('.legend-item')
          .data(this.languages)
          .enter()
          .append('g')
          .attr('class', 'legend-item')
          .attr('transform', (d, i) => 'translate(0,' + i * 20 + ')');
  
        legendItem
          .append('rect')
          .attr('width', 12)
          .attr('height', 12)
          .attr('fill', (d, i) => this.colors(i));
  
        legendItem
          .append('text')
          .attr('x', 20)
          .attr('y', 10)
          .attr('dy', '0.35em')
          .text((d) => d.Language + ' (' + d.Percentage + '%)');
      },
    },
  };
  </script>
  
  <style scoped>
  .arc {
    stroke: #fff;
  }
  </style>
  