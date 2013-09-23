<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" exclude-result-prefixes="kml atom" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:kml="http://earth.google.com/kml/2.2" xmlns:georss="http://www.georss.org/georss" xmlns:atom="http://www.w3.org/2005/Atom">
	<xsl:output method="xml" cdata-section-elements="category"/>
	<xsl:strip-space elements="*"/>
	<xsl:param name="feedURL" select="document('http://spreadsheets.google.com/pub?key=ttpFuYJz9bXTx3nuCQrTvYg&amp;output=txt&amp;output=txt&amp;gid=0&amp;range=kml_output')"/>
	<xsl:attribute-set name="hrefs">
		<xsl:attribute name="type">html</xsl:attribute>
	</xsl:attribute-set>
	<xsl:template match="/">
		<feed xmlns="http://www.w3.org/2005/Atom" xmlns:georss="http://www.georss.org/georss">
			<title>The Platform for Agrobiodiversity Research (PAR)</title>
			<link href="http://agrobiodiversityplatform.org/climatechange/charting-adaptation-1/"/>
			<updated>2002-10-02T15:00:00Z</updated>
			<author>
				<name>Bioversity International</name>
				<email>platformcoordinator@cgiar.org</email>
			</author>
			<id>urn:uuid:0d1d9260-854e-11e0-87c5-0002a5d5c51b</id>
			<xsl:apply-templates select="$feedURL//kml:Placemark"/>
		</feed>
	</xsl:template>
	<xsl:template match="kml:Placemark">
		<xsl:variable name="pId" select="@id"/>
		<xsl:if test="kml:ExtendedData/kml:Data[@name = 'AMKN']/kml:value != ''">
			<xsl:variable name="url" select="kml:ExtendedData/kml:Data[@name = 'Learn_More_URL']/kml:value"/>
			<xsl:variable name="amknVar" select="kml:ExtendedData/kml:Data[@name = 'AMKN']/kml:value"/>
			<xsl:element name="entry" namespace="http://www.w3.org/2005/Atom" xml:space="preserve">
				<xsl:element name="title" namespace="http://www.w3.org/2005/Atom" xml:space="preserve">
					<xsl:value-of select="kml:ExtendedData/kml:Data[@name = 'Title']/kml:value"/>
				</xsl:element>
				<xsl:element name="updated" namespace="http://www.w3.org/2005/Atom" xml:space="preserve">2010-01-01T15:00:00Z</xsl:element>
<xsl:call-template name="ots"><xsl:with-param name="list" select="$amknVar" /></xsl:call-template>
				<xsl:element name="category" namespace="http://www.w3.org/2005/Atom" xml:space="preserve"><xsl:attribute name="term" xml:space="preserve">use of agrobiodiversity</xsl:attribute><xsl:attribute name="nicename" xml:space="preserve">use-of-agrobiodiversity</xsl:attribute><xsl:attribute name="domain" xml:space="preserve">adaptation_strategy</xsl:attribute></xsl:element>
				<xsl:if test="not(contains(kml:ExtendedData/kml:Data[@name = 'Agroforestry']/kml:value, 'empty-icon.JPG'))">
					<xsl:element name="category" namespace="http://www.w3.org/2005/Atom" xml:space="preserve"><xsl:attribute name="term" xml:space="preserve">Agroforestry</xsl:attribute></xsl:element>
				</xsl:if>
				<xsl:if test="not(contains(kml:ExtendedData/kml:Data[@name = 'Animals']/kml:value, 'empty-icon.JPG'))">
					<xsl:element name="category" namespace="http://www.w3.org/2005/Atom" xml:space="preserve"><xsl:attribute name="term" xml:space="preserve">Livestock&#44; Fisheries and Bees</xsl:attribute></xsl:element>
				</xsl:if>
				<xsl:if test="not(contains(kml:ExtendedData/kml:Data[@name = 'Diet_Div']/kml:value, 'empty-icon.JPG'))">
					<xsl:element name="category" namespace="http://www.w3.org/2005/Atom" xml:space="preserve"><xsl:attribute name="term" xml:space="preserve">Diet Diversification</xsl:attribute></xsl:element>
				</xsl:if>
				<xsl:if test="not(contains(kml:ExtendedData/kml:Data[@name = 'Cultivation_Practice']/kml:value, 'empty-icon.JPG'))">
					<xsl:element name="category" namespace="http://www.w3.org/2005/Atom" xml:space="preserve"><xsl:attribute name="term" xml:space="preserve">Cropping Systems</xsl:attribute></xsl:element>
				</xsl:if>
				<xsl:if test="not(contains(kml:ExtendedData/kml:Data[@name = 'Institutional_Strength']/kml:value, 'empty-icon.JPG'))">
					<xsl:element name="category" namespace="http://www.w3.org/2005/Atom" xml:space="preserve"><xsl:attribute name="term" xml:space="preserve">Biodiversity Management</xsl:attribute></xsl:element>
				</xsl:if>
				<xsl:if test="not(contains(kml:ExtendedData/kml:Data[@name = 'Stress_Tolerant']/kml:value, 'empty-icon.JPG'))">
					<xsl:element name="category" namespace="http://www.w3.org/2005/Atom" xml:space="preserve"><xsl:attribute name="term" xml:space="preserve">Stress-tolerant Crops</xsl:attribute></xsl:element>
				</xsl:if>
				<xsl:if test="not(contains(kml:ExtendedData/kml:Data[@name = 'Water_Soil_Management']/kml:value, 'empty-icon.JPG'))">
					<xsl:element name="category" namespace="http://www.w3.org/2005/Atom" xml:space="preserve"><xsl:attribute name="term" xml:space="preserve">Soil and Water Management</xsl:attribute></xsl:element>
				</xsl:if>
				<xsl:if test="not(contains(kml:ExtendedData/kml:Data[@name = 'Org_Agri']/kml:value, 'empty-icon.JPG'))">
					<xsl:element name="category" namespace="http://www.w3.org/2005/Atom" xml:space="preserve"><xsl:attribute name="term" xml:space="preserve">Organic Agriculture</xsl:attribute></xsl:element>
				</xsl:if>
				<xsl:if test="not(contains(kml:ExtendedData/kml:Data[@name = 'Landscape']/kml:value, 'empty-icon.JPG'))">
					<xsl:element name="category" namespace="http://www.w3.org/2005/Atom" xml:space="preserve"><xsl:attribute name="term" xml:space="preserve">Landscape Restoration</xsl:attribute></xsl:element>
				</xsl:if>
				<link href="{normalize-space($url)}"/>
				<xsl:element name="id" namespace="http://www.w3.org/2005/Atom" xml:space="preserve">urn:agro-biov:<xsl:value-of select="$pId"/></xsl:element>
				<xsl:element name="summary" namespace="http://www.w3.org/2005/Atom" xml:space="preserve" use-attribute-sets="hrefs">
					<xsl:text disable-output-escaping="yes">&lt;![CDATA[</xsl:text>
					<xsl:value-of select="kml:ExtendedData/kml:Data[@name = 'Paragraph_1']/kml:value" disable-output-escaping="yes"/>
					<xsl:text>&#160;</xsl:text>
					<xsl:value-of select="kml:ExtendedData/kml:Data[@name = 'Paragraph_2']/kml:value" disable-output-escaping="yes"/>
					<xsl:text disable-output-escaping="yes">]]&gt;</xsl:text>
				</xsl:element>
				<xsl:element name="georss:point"><xsl:value-of select="substring-after(kml:Point/kml:coordinates,',')"/><xsl:text> </xsl:text><xsl:value-of select="substring-before(kml:Point/kml:coordinates,',')"/></xsl:element>
			</xsl:element>
		</xsl:if>
	</xsl:template>
<xsl:template name="ots">
    <xsl:param name="list" /> 
    <xsl:variable name="newlist" select="$list" /> 
    <xsl:variable name="first" select="substring-before($newlist, ',')" /> 
    <xsl:variable name="remaining" select="substring-after($newlist, ',')" /> 
    <xsl:if test="$first">
	<xsl:element name="category" namespace="http://www.w3.org/2005/Atom" xml:space="preserve"><xsl:attribute name="term" xml:space="preserve"><xsl:value-of select="normalize-space($first)" /></xsl:attribute></xsl:element>
    </xsl:if>
    <xsl:if test="not($first)">
	<xsl:element name="category" namespace="http://www.w3.org/2005/Atom" xml:space="preserve"><xsl:attribute name="term" xml:space="preserve"><xsl:value-of select="normalize-space($list)" /></xsl:attribute></xsl:element>
    </xsl:if>
    <xsl:if test="$remaining">
        <xsl:call-template name="ots"><xsl:with-param name="list" select="$remaining" /></xsl:call-template>
    </xsl:if>
</xsl:template>	
</xsl:stylesheet>