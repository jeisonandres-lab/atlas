/**
 * Gráficos del Panel Principal - ApexCharts
 * Estilo: elegante, colorido y profesional (RRHH)
 */

const CHART_COLORS = {
    primary: '#7C3AED',      // violeta
    secondary: '#0EA5E9',    // cyan/sky
    primario: '#1929bb',     // colores.css --color-primario
    segundario: '#3B82F6',   // colores.css --color-segundario
    success: '#10B981',      // esmeralda
    warning: '#F59E0B',      // ámbar
    danger: '#EF4444',       // rojo
    purple: '#8B5CF6',
    teal: '#14B8A6',
    pink: '#EC4899',
    gradient: {
        purple: ['#A78BFA', '#7C3AED'],
        cyan: ['#38BDF8', '#0EA5E9'],
        green: ['#34D399', '#10B981'],
        orange: ['#FBBF24', '#F59E0B'],
    }
};

const COMMON_CHART_OPTIONS = {
    chart: {
        fontFamily: 'inherit',
        toolbar: { show: false },
        animations: {
            enabled: true,
            easing: 'easeinout',
            speed: 800,
        },
    },
    colors: [CHART_COLORS.primary, CHART_COLORS.secondary, CHART_COLORS.success, CHART_COLORS.teal, CHART_COLORS.pink, CHART_COLORS.warning],
    dataLabels: { enabled: false },
    grid: {
        borderColor: '#E2E8F0',
        strokeDashArray: 4,
        xaxis: { lines: { show: false } },
        yaxis: { lines: { show: true } },
    },
    legend: {
        fontSize: '13px',
        fontWeight: 500,
        itemMargin: { horizontal: 12 },
        markers: { radius: 8 },
    },
    tooltip: {
        theme: 'light',
        style: { fontSize: '12px' },
        y: { formatter: (val) => val != null ? `${val}` : '' },
    },
    xaxis: {
        labels: {
            style: { colors: '#64748B', fontSize: '11px' },
            trim: true,
            maxHeight: 80,
        },
        axisBorder: { show: false },
        axisTicks: { show: false },
    },
    yaxis: {
        labels: {
            style: { colors: '#64748B', fontSize: '11px' },
            formatter: (val) => {
                if (val == null || val === '') return '';
                const n = Number(val);
                if (isNaN(n)) return val;
                return n % 1 === 0 ? String(n) : String(Math.round(n));
            },
        },
        axisBorder: { show: false },
        axisTicks: { show: false },
    },
    stroke: { curve: 'smooth', width: 2 },
    plotOptions: {
        bar: {
            borderRadius: 6,
            columnWidth: '60%',
            distributed: false,
            dataLabels: {
                position: 'top',
                style: { fontSize: '10px' },
            },
        },
    },
};

async function fetchData(url) {
    try {
        const response = await fetch(url);
        return await response.json();
    } catch (err) {
        console.error('Error fetching data:', err);
        return null;
    }
}

let chartResumen = null;
let chartMes = null;
let chartPorFecha = null;
let chartGrowth = null;

/**
 * Resumen: archivos por día (barras verticales coloridas)
 */
export async function renderChartResumen() {
    const dataDia = await fetchData('src/ajax/totalDate.php?modulo_Datos=totalArchivosDia');
    const el = document.getElementById('scoreChart');
    if (!el || !dataDia?.exito) return;

    const categories = dataDia.values || [];
    const rawLabels = dataDia.labels || [];
    const originalLabels = dataDia.original_labels || [];
    const seriesValues = rawLabels.map((v, i) => {
        if (typeof v === 'number') return v;
        const num = parseFloat(String(v).replace(',', '.')) || parseInt(String(v).replace(/\D/g, ''), 10) || 0;
        return num;
    });

    // Dos azules elegantes: oscuro clarito y más clarito (alternando por barra)
    const azulOscuro = '#2563eb';
    const azulClaro = '#60a5fa';
    const barColors = seriesValues.map((_, i) => (i % 2 === 0 ? azulOscuro : azulClaro));

    const options = {
        ...COMMON_CHART_OPTIONS,
        chart: {
            ...COMMON_CHART_OPTIONS.chart,
            type: 'bar',
            height: 320,
        },
        grid: {
            ...COMMON_CHART_OPTIONS.grid,
            padding: { bottom: 24 },
        },
        series: [{ name: 'Archivos en el mes actual', data: seriesValues }],
        colors: barColors,
        fill: {
            type: 'solid',
            opacity: 1,
        },
        plotOptions: {
            bar: {
                ...COMMON_CHART_OPTIONS.plotOptions.bar,
                borderRadius: 0,
                columnWidth: '55%',
                distributed: true,
            },
        },
        tooltip: {
            ...COMMON_CHART_OPTIONS.tooltip,
            custom: function ({ series, seriesIndex, dataPointIndex }) {
                const val = series[seriesIndex]?.[dataPointIndex] ?? seriesValues[dataPointIndex];
                const meta = originalLabels[dataPointIndex] != null ? ` (${originalLabels[dataPointIndex]})` : '';
                return `<div class="apexcharts-tooltip-title">${categories[dataPointIndex]}</div><div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-text">Archivos: ${val}${meta}</span></div>`;
            },
        },
        xaxis: {
            ...COMMON_CHART_OPTIONS.xaxis,
            categories,
        },
        yaxis: {
            ...COMMON_CHART_OPTIONS.yaxis,
            min: 0,
            forceNiceScale: true,
        },
        legend: { show: false },
    };

    if (chartResumen) chartResumen.destroy();
    chartResumen = new ApexCharts(el, options);
    await chartResumen.render();
}

/**
 * Total de archivos por mes (línea/área con gradiente, colorida)
 */
export async function renderChartMes() {
    const dataMes = await fetchData('src/ajax/totalDate.php?modulo_Datos=totalArchivosMes');
    const el = document.getElementById('scoreChart2');
    if (!el || !dataMes?.exito) return;

    const categories = dataMes.values || [];
    const rawLabels = dataMes.labels || [];
    const originalLabels = dataMes.original_labels || [];
    const seriesValues = rawLabels.map((v, i) => {
        if (typeof v === 'number') return v;
        return parseFloat(String(v).replace(',', '.')) || parseInt(String(v).replace(/\D/g, ''), 10) || 0;
    });

    const options = {
        ...COMMON_CHART_OPTIONS,
        chart: {
            ...COMMON_CHART_OPTIONS.chart,
            type: 'area',
            height: 320,
            zoom: { enabled: false },
            events: {
                dataPointSelection: (e, chart, opts) => {
                    const label = categories[opts.dataPointIndex];
                    if (label) loadChartPorFecha(label);
                },
            },
        },
        series: [{ name: 'Archivos por mes', data: seriesValues }],
        colors: [CHART_COLORS.success],
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: 'vertical',
                shadeIntensity: 0.4,
                opacityFrom: 0.7,
                opacityTo: 0.2,
                stops: [0, 90],
                colorStops: [
                    { offset: 0, color: CHART_COLORS.success, opacity: 0.8 },
                    { offset: 100, color: CHART_COLORS.teal, opacity: 0.3 },
                ],
            },
        },
        stroke: { curve: 'smooth', width: 2.5 },
        markers: {
            size: 4,
            colors: [CHART_COLORS.success],
            strokeColors: '#fff',
            strokeWidth: 2,
            hover: { size: 6 },
        },
        tooltip: {
            ...COMMON_CHART_OPTIONS.tooltip,
            custom: function ({ series, seriesIndex, dataPointIndex }) {
                const val = series[seriesIndex]?.[dataPointIndex] ?? seriesValues[dataPointIndex];
                const meta = originalLabels[dataPointIndex] != null ? ` (${originalLabels[dataPointIndex]})` : '';
                return `<div class="apexcharts-tooltip-title">${categories[dataPointIndex]}</div><div class="apexcharts-tooltip-series-group"><span class="apexcharts-tooltip-text">Cantidad: ${val}${meta}</span></div>`;
            },
        },
        xaxis: {
            ...COMMON_CHART_OPTIONS.xaxis,
            categories,
        },
        yaxis: {
            ...COMMON_CHART_OPTIONS.yaxis,
            min: 0,
            forceNiceScale: true,
        },
    };

    if (chartMes) chartMes.destroy();
    if (chartPorFecha) {
        chartPorFecha.destroy();
        chartPorFecha = null;
    }
    chartMes = new ApexCharts(el, options);
    await chartMes.render();
}

/**
 * Drill-down: archivos por día dentro de un mes
 */
export async function loadChartPorFecha(date) {
    const el = document.getElementById('scoreChart2');
    if (!el) return;

    const parts = String(date).split('-');
    const year = parseInt(parts[0], 10);
    const month = parseInt(parts[1], 10);
    const daysInMonth = new Date(year, month, 0).getDate();

    const categories = Array.from({ length: daysInMonth }, (_, i) =>
        `${date}-${String(i + 1).padStart(2, '0')}`
    );
    const seriesData = Array.from({ length: daysInMonth }, () =>
        Math.floor(Math.random() * 40) + 5
    );

    const options = {
        ...COMMON_CHART_OPTIONS,
        chart: {
            ...COMMON_CHART_OPTIONS.chart,
            type: 'bar',
            height: 320,
        },
        series: [{ name: `Archivos en ${date}`, data: seriesData }],
        colors: [CHART_COLORS.secondary],
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'light',
                type: 'vertical',
                shadeIntensity: 0.3,
                opacityFrom: 0.8,
                opacityTo: 0.5,
                stops: [0, 100],
                colorStops: [
                    { offset: 0, color: CHART_COLORS.secondary, opacity: 1 },
                    { offset: 100, color: CHART_COLORS.teal, opacity: 0.8 },
                ],
            },
        },
        plotOptions: {
            bar: {
                ...COMMON_CHART_OPTIONS.plotOptions.bar,
                borderRadius: 6,
                columnWidth: '70%',
            },
        },
        xaxis: {
            ...COMMON_CHART_OPTIONS.xaxis,
            categories,
            labels: { rotate: -45, maxHeight: 80 },
        },
        yaxis: {
            ...COMMON_CHART_OPTIONS.yaxis,
            min: 0,
            forceNiceScale: true,
        },
    };

    if (chartMes) {
        chartMes.destroy();
        chartMes = null;
    }
    if (chartPorFecha) chartPorFecha.destroy();
    chartPorFecha = new ApexCharts(el, options);
    await chartPorFecha.render();

    showBackButton();
}

function showBackButton() {
    let btn = document.getElementById('chartBackBtn');
    if (btn) return;
    const container = document.getElementById('contentbutton');
    if (!container) return;
    btn = document.createElement('button');
    btn.id = 'chartBackBtn';
    btn.type = 'button';
    btn.className = 'btn btn-primary btn-sm rounded-2';
    btn.textContent = 'Regresar';
    btn.onclick = async () => {
        btn.remove();
        await renderChartMes();
    };
    container.appendChild(btn);
}

/**
 * Crecimiento: radial (78%) - estilo gauge elegante
 */
export function renderChartGrowth() {
    const el = document.getElementById('growthDonut');
    if (!el) return;

    const options = {
        chart: {
            type: 'radialBar',
            height: 220,
            fontFamily: 'inherit',
            animations: { enabled: true, speed: 800 },
            sparkline: { enabled: false },
        },
        colors: [CHART_COLORS.primary],
        plotOptions: {
            radialBar: {
                hollow: { size: '65%', margin: 0 },
                track: { background: '#E2E8F0', margin: 0, strokeWidth: '100%' },
                dataLabels: {
                    name: { show: false },
                    value: {
                        show: true,
                        fontSize: '18px',
                        fontWeight: 600,
                        color: '#334155',
                        offsetY: -2,
                        formatter: (val) => `${val}%`,
                    },
                    total: {
                        show: true,
                        label: 'Crecimiento',
                        fontSize: '11px',
                        fontWeight: 500,
                        color: '#64748B',
                        formatter: () => '',
                    },
                },
            },
        },
        fill: {
            type: 'gradient',
            gradient: {
                shade: 'dark',
                type: 'horizontal',
                shadeIntensity: 0.5,
                opacityFrom: 1,
                opacityTo: 0.85,
                stops: [0, 100],
                colorStops: [
                    { offset: 0, color: '#A78BFA', opacity: 1 },
                    { offset: 100, color: CHART_COLORS.primary, opacity: 1 },
                ],
            },
        },
        stroke: { lineCap: 'round' },
        labels: [78],
        series: [78],
    };

    if (chartGrowth) chartGrowth.destroy();
    chartGrowth = new ApexCharts(el, options);
    chartGrowth.render();
}

/**
 * Inicializa todos los gráficos del home
 */
export async function initHomeCharts() {
    await Promise.all([
        renderChartResumen(),
        renderChartMes(),
        Promise.resolve(renderChartGrowth()),
    ]);
}
