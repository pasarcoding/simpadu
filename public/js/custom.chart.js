// Fungsi untuk membuat atau mendapatkan list UL untuk legend
const getOrCreateLegendList = (chart, id) => {
    const legendContainer = document.getElementById(id);
    if (!legendContainer) return null;

    let listContainer = legendContainer.querySelector("ul");

    if (!listContainer) {
        listContainer = document.createElement("ul");
        listContainer.classList.add("legend-list-container");
        legendContainer.appendChild(listContainer);
    }
    return listContainer;
};

// Plugin kustom untuk render HTML Legend
const htmlLegendPlugin = {
    id: "htmlLegend",
    afterUpdate(chart, args, options) {
        const ul = getOrCreateLegendList(chart, options.containerID);

        if (!ul) return;

        while (ul.firstChild) {
            ul.firstChild.remove();
        }

        const items = chart.options.plugins.legend.labels.generateLabels(chart);

        items.forEach((item) => {
            const li = document.createElement("li");

            li.classList.add("legend-list-item");
            if (item.hidden) {
                li.classList.add("hidden");
            }

            li.onclick = () => {
                const { type } = chart.config;
                if (type === "pie" || type === "doughnut") {
                    chart.toggleDataVisibility(item.index);
                } else {
                    chart.setDatasetVisibility(
                        item.datasetIndex,
                        !chart.isDatasetVisible(item.datasetIndex)
                    );
                }
                chart.update();
            };

            const boxSpan = document.createElement("span");
            boxSpan.classList.add("legend-color-box");
            boxSpan.style.background = item.fillStyle;
            boxSpan.style.borderColor = item.strokeStyle;
            boxSpan.style.borderWidth = item.lineWidth + "px";

            const textContainer = document.createElement("p");
            textContainer.classList.add("legend-text");

            const fontColor =
                chart.options.plugins.legend.labels.color || "#1f2937";
            textContainer.style.color = fontColor;

            const text = document.createTextNode(item.text);
            textContainer.appendChild(text);

            li.appendChild(boxSpan);
            li.appendChild(textContainer);
            ul.appendChild(li);
        });

        const hasOverflow = ul.scrollWidth > ul.clientWidth;

        if (!hasOverflow) {
            ul.classList.add("center-if-small");
        } else {
            ul.classList.remove("center-if-small");
        }
    },
};
