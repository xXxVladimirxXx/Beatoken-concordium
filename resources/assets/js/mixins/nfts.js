function parseMetaAttributes(nft) {
    if (nft.metadata && nft.metadata.name) {
        if (nft.metadata.attributes) {
            var type = nft.metadata.attributes.find(e => e.attribute_type == 'type')
            var attachment = nft.metadata.attributes.find(e => e.attribute_type == 'attachment')
            var author = nft.metadata.attributes.find(e => e.attribute_type == 'author')
            var numbering = nft.metadata.attributes.find(e => e.attribute_type == 'numbering')
            if (type) nft.type = type
            if (attachment) nft.attachment = attachment
            if (author) nft.author = author
            if (numbering) nft.numbering = numbering
        }
        return nft
    }
    return {}
}

export {parseMetaAttributes}
